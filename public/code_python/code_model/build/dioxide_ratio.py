import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split, GridSearchCV, RandomizedSearchCV
import joblib
from scipy.stats import randint
from sklearn.preprocessing import LabelEncoder
from sklearn.preprocessing import MinMaxScaler, PolynomialFeatures
from sklearn.ensemble import GradientBoostingRegressor, RandomForestRegressor
import os

#! Get the directory of the current script
current_directory = os.path.dirname(os.path.abspath(__file__))

# !Get the base path by going up one directory
base_path = os.path.dirname(current_directory)
dataset = base_path+"\\dataset\\final_personal.csv"
modelpath = base_path+"\\code_model\\footprint\\person\\best_model.pkl"
encoderpath = base_path+"\\code_model\\footprint\\person\\label_encoders.pkl"

df=pd.read_csv(dataset)

# print(data.tail())


# Define categorical columns
columns = ['country', 'type_house', 'Heating energy', 'household preferred diet',
           'local_products?', 'buy _environmentally_companies?', 'HANDLE WASTE?']

# Initialize an empty dictionary to store label encoders
label_encoders = {}

# Apply label encoding to each categorical column
for col in columns:
    le = LabelEncoder()
    df[col] = le.fit_transform(df[col])
    label_encoders[col] = le


columnss = ['num_people', 'country', 'size_house', 'type_house',
          'Electricity_consumption', 'clean_energy', 'Heating energy',
           'IntercityTrain_avghours', 'Subway_avghours', 'IntercityBus_avghours',
          'City Bus_avghours', 'Tram_avghours', 'Bike/walk_avghours',
         'plane_verylong', 'plane_long', 'plane_medium', 'plane_short',
          'household preferred diet', 'local_products?',
          'buy _environmentally_companies?',
         'How many times a week does your family eat out?', 'HANDLE WASTE?','gasoline',
         'natural gas ','water consumtion','waste quantity','ferune','fruite out of season']


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
# # ##############################polynomial
# #

# Load your data (assuming X, t are your features and target variable)
# Replace this with your actual data loading process
# X = ...
# t = ...

# Split the data into training, validation, and test sets
X_trainval, X_test, t_trainval, t_test = train_test_split(X, t, test_size=0.20, random_state=42)

# Reduce Grid Size
param_grid = {
    'learning_rate': [0.001, 0.01,0.0001],
    'n_estimators': [50, 100],
    'max_depth': [3, 5],
    'min_samples_split': [2, 5],
    'min_samples_leaf': [1, 2]
}

# Parallelization
grid_search = GridSearchCV(GradientBoostingRegressor(random_state=42), param_grid, cv=5, scoring='neg_mean_squared_error', n_jobs=-1)

# Use RandomizedSearchCV
param_dist = {
    'learning_rate': [0.01, 0.1, 0.0001],
    'n_estimators': randint(50, 200),
    'max_depth': randint(3, 10),
    'min_samples_split': randint(2, 20),
    'min_samples_leaf': randint(1, 10)
}
random_search = RandomizedSearchCV(GradientBoostingRegressor(random_state=42), param_distributions=param_dist, n_iter=100, cv=5, scoring='neg_mean_squared_error', n_jobs=-2)

# Data Sampling
X_trainval_sampled, _, t_trainval_sampled, _ = train_test_split(X_trainval, t_trainval, test_size=0.20, random_state=42)

# Model Selection
regressor = RandomForestRegressor()

# Train the model
regressor.fit(X_trainval_sampled, t_trainval_sampled)

# Make predictions on the test set
t_pred = regressor.predict(X_test)

# Save the model to a file
joblib.dump(regressor, modelpath)
joblib.dump(label_encoders, encoderpath)

print("build Model Success")