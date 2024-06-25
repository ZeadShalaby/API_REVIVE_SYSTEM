import pandas as pd
import numpy as np
from sklearn.metrics import accuracy_score, f1_score, classification_report
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import GaussianNB
from sklearn.preprocessing import MinMaxScaler, LabelEncoder, PolynomialFeatures
from joblib import *
from sklearn.ensemble import GradientBoostingClassifier
from sklearn.tree import DecisionTreeClassifier

import os

#! Get the directory of the current script
current_directory = os.path.dirname(os.path.abspath(__file__))

# !Get the base path by going up one directory
base_path = os.path.dirname(current_directory)
dataset = base_path+"\\dataset\\final_weather.csv"
modelpath = base_path+"\\code_model\\weather\\best_classifier.pkl"


# Read the Excel file
df = pd.read_csv(dataset)

t = df['class']
data=df.drop('class', axis=1)

def min_max_scaler(data):
    columns_to_scale = ['co', 'co2', 'o2', 'degree', 'humidity']

    # Exclude the 'class' column from the data
    data_to_scale = data[columns_to_scale]

    # Initialize MinMaxScaler
    scaler = MinMaxScaler()

    # Fit and transform the data
    scaled_data = scaler.fit_transform(data_to_scale)

    # Create a DataFrame with the scaled data
    scaled_data = pd.DataFrame(scaled_data, columns=columns_to_scale)

    return scaled_data


# # #################
scaled_data=min_max_scaler(data)
X=scaled_data
##############################

import pandas as pd
from sklearn.model_selection import train_test_split, GridSearchCV, RandomizedSearchCV
from sklearn.ensemble import GradientBoostingClassifier, RandomForestClassifier
from sklearn import metrics
import joblib
from scipy.stats import randint


# Split the data into training, validation, and test sets
X_trainval, X_test, t_trainval, t_test = train_test_split(X, t, test_size=0.20, random_state=42,shuffle=True)

# Reduce Grid Size
param_grid = {
    'learning_rate': [0.001, 0.01, 0.0001],
    'n_estimators': [50, 100],
    'max_depth': [3, 5],
    'min_samples_split': [2, 5],
    'min_samples_leaf': [1, 2]
}

# # Parallelization
grid_search = GridSearchCV(GradientBoostingClassifier(random_state=42), param_grid, cv=5, scoring='accuracy', n_jobs=-1)

# Use RandomizedSearchCV
param_dist = {
    'learning_rate': [0.01, 0.1, 0.0001],
    'n_estimators': randint(50, 200),
    'max_depth': randint(3, 10),
    'min_samples_split': randint(2, 20),
    'min_samples_leaf': randint(1, 10)
}
random_search = RandomizedSearchCV(GradientBoostingClassifier(random_state=42), param_distributions=param_dist, n_iter=100, cv=5, scoring='accuracy', n_jobs=-2)

# Data Sampling
X_trainval_sampled, X_test, t_trainval_sampled, t_test = train_test_split(X_trainval, t_trainval, test_size=0.20, random_state=42,shuffle=True)

# Model Selection
classifier = RandomForestClassifier()

# Train the model
classifier.fit(X_trainval_sampled, t_trainval_sampled)

# Make predictions on the test set
t_pred = classifier.predict(X_test)


# Save the model to a file
joblib.dump(classifier, modelpath)
print("build model Success")