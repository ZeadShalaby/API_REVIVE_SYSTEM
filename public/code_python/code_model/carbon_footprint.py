import pandas as pd
import joblib
from sklearn.preprocessing import PolynomialFeatures

import json
import os

#! Get the directory of the current script
current_directory = os.path.dirname(os.path.abspath(__file__))

# !Get the base path by going up one directory
base_path = os.path.dirname(current_directory)
path = base_path+"\\json\\data.json"
modelpath = base_path+"\\code_model\\footprint\\factory\\best_model.pkl"
encoderfactpath = base_path+"\\code_model\\footprint\\factory\\label_encoders.pkl"


#! Open the file for reading
with open(path, 'r') as file:
    # Read the JSON data from the file
    json_data = json.load(file)

# todo Use pd.json_normalize to convert the JSON to a DataFrame
df = pd.json_normalize(json_data)

# print(data.tail())

loaded_model = joblib.load(modelpath)

label_encoders = joblib.load(encoderfactpath)


df = pd.DataFrame(df)

for col, encoder in label_encoders.items():
    if col in df.columns:
        df[col] = encoder.transform(df[col])


degree=4
poly = PolynomialFeatures(degree=degree, include_bias=True)
X_new = poly.fit_transform(df)
# X_new2 = poly.fit_transform(Labeled_data2)

prediction = loaded_model.predict(X_new)

print(prediction[0])