import pandas as pd
import numpy as np
import joblib
from sklearn import datasets, linear_model
from sklearn.model_selection import train_test_split, KFold, GridSearchCV
from sklearn.linear_model import LinearRegression, Ridge
from sklearn.metrics import mean_squared_error, accuracy_score
from joblib import dump  # Use 'dump' instead of 'model'
import joblib  # Ensure that joblib is imported
from sklearn.preprocessing import MinMaxScaler, PolynomialFeatures, LabelEncoder
from sklearn.ensemble import GradientBoostingRegressor, RandomForestRegressor

df=pd.read_excel('final_factory.xlsx')
columns = ['country', 'local_products?', 'buy _environmentally_companies?', 'HANDLE WASTE?','Heating energy']

label_encoderfact = {}

# Apply label encoding to each categorical column
for col in columns:
    le = LabelEncoder()
    df[col] = le.fit_transform(df[col])
    # Store the label encoder for later use during prediction
    label_encoderfact[col] = le

columnss = ['country', 'num_people', 'Electricity_consumption', 'clean_energy',
          'num_cars', 'factory_size', 'local_products?',
           'buy _environmentally_companies?', 'HANDLE WASTE?', 'Heating energy',
          'gasoline', 'natural gas ', 'water consumtion','waste quantity']


###############################outlier
def outliers(df, ft):
    Q1 = df[ft].quantile(0.25)
    Q3 = df[ft].quantile(0.75)
    IQR = Q3 - Q1
    lower_bound = Q1 - 1.5 * IQR
    upper_bound = Q3 + 1.5 * IQR
    ls = df.index[(df[ft].astype(float) < lower_bound) | (df[ft].astype(float) > upper_bound)]

    return ls

index_list = []
for feature in columnss:
    index_list.extend(outliers(df, feature))

def remove(df, ls):
    ls = sorted(set(ls))
    df = df.drop(ls)
    return df

Labeled_data=remove(df,index_list)

# # print(Labeled_data.head())
# # print(Labeled_data.columns)
#
# ##############################
# #
X=Labeled_data.drop('Carbon_precentage',axis=1)
t=Labeled_data['Carbon_precentage']
# ########################################################### Mini Max Scaler
#
def fit_transform(data):
    processor = MinMaxScaler()
    return processor.fit_transform(data), processor
# #
# # ############################## polynomial

degree=4
poly = PolynomialFeatures(degree=degree, include_bias=True)
X_new = poly.fit_transform(X)

def split(X_trainval, t_trainval):
    X_train, X_val, t_train, t_val = \
        train_test_split(X, t, test_size=0.25,
                         random_state=42, shuffle=True)

    return X_train, X_val, t_train, t_val

# # ########################################################

def split_test(X, t):
    X_train, X_test, t_train, t_test = \
        train_test_split(X, t, test_size=0.20,
                         random_state=42, shuffle=True)

    return X_train, X_test, t_train, t_test
#
#
def train_eval_process(model, X_train, X_val, t_train, t_val):
    model.fit(X_train, t_train)

    pred_train = model.predict(X_train)
    error_train = mean_squared_error(t_train, pred_train)

    pred_val = model.predict(X_val)
    error_val = mean_squared_error(t_val, pred_val)
    joblib.dump(model, "footprint/fact_model.pkl")
    return error_train, error_val

# X_trainval, X_test, t_trainval, t_test=train_test_split(X_new, t, test_size=20, random_state=42, shuffle=True)
# X_train, X_val, t_train, t_val=split(X_trainval, t_trainval)
X_train, X_test, t_train, t_test =split_test(X_new,t)
def fit_transform(X_train, X_test):
    scaler = MinMaxScaler()
    X_train_scaled = scaler.fit_transform(X_train)
    X_val_scaled = scaler.transform(X_test)
    return X_train_scaled, X_val_scaled

X_train_scaled, X_val_scaled = fit_transform(X_train, X_test)

print(train_eval_process(LinearRegression(),X_train,X_test, t_train, t_test))
joblib.dump(label_encoderfact, 'footprint/label_encoderfact.pkl')