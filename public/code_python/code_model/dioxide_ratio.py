import pandas as pd
import joblib
import json
import os

#! Get the directory of the current script
current_directory = os.path.dirname(os.path.abspath(__file__))

# !Get the base path by going up one directory
base_path = os.path.dirname(current_directory)
path = base_path+"\\json\\data.json"
modelpath = base_path+"\\code_model\\footprint\\person\\best_model.pkl"
encoderpath = base_path+"\\code_model\\footprint\\person\\label_encoders.pkl"

#! Open the file for reading
with open(path, 'r') as file:
    # Read the JSON data from the file
    json_data = json.load(file)

# todo Use pd.json_normalize to convert the JSON to a DataFrame
df = pd.json_normalize(json_data)

# Load the trained model
loaded_model = joblib.load(modelpath)

# Load the stored label encoders
label_encoders = joblib.load(encoderpath)

# Define your data

# Create DataFrame


# Encode categorical columns using stored label encoders
for col, encoder in label_encoders.items():
    if col in df.columns:
        df[col] = encoder.transform(df[col])

# Make prediction
prediction = loaded_model.predict(df)
print(prediction[0])