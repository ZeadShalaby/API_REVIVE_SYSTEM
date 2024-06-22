import warnings
import pandas as pd
import joblib
from sklearn.preprocessing import PolynomialFeatures
import json
import os

# Suppress the specific InconsistentVersionWarning
warnings.filterwarnings('ignore', category=UserWarning, module='sklearn.base')

# Get the directory of the current script
current_directory = os.path.dirname(os.path.abspath(__file__))

# Get the base path by going up one directory
base_path = os.path.dirname(current_directory)
path = os.path.join(base_path, "json", "data.json")
modelpath = os.path.join(base_path, "code_model", "footprint", "factory", "fact_model.pkl")
encoderfactpath = os.path.join(base_path, "code_model", "footprint", "factory", "label_encoderfact.pkl")

# Open the file for reading
with open(path, 'r') as file:
    # Read the JSON data from the file
    json_data = json.load(file)

# Use pd.json_normalize to convert the JSON to a DataFrame
df_norm = pd.json_normalize(json_data)

df = pd.DataFrame(df_norm)
columns = ['country', 'local_products?', 'buy _environmentally_companies?', 'HANDLE WASTE?','Heating energy']


# ! Corrected conditional checks
if df['HANDLE WASTE?'][0] in ['Food', 'Glass', 'Plastic']:
    print('For Reducing your carbon footprint the handle_waste should be in these choices [Paper, Tin cans, cartoon]')

if df['Heating energy'][0] in ['Wood', 'Coal', 'Natural Gas']:
    print('For Reducing your carbon footprint Heating energy should be in these choices [Electricity, solar energy, Hydroelectric energy, Electromagnetic energy]')


loaded_model = joblib.load(modelpath)
label_encoders = joblib.load(encoderfactpath)

for col, encoder in label_encoders.items():
    if col in df.columns:
        df[col] = encoder.transform(df[col])

degree = 4
poly = PolynomialFeatures(degree=degree, include_bias=True)
X_new = poly.fit_transform(df)
prediction = loaded_model.predict(X_new)

print(prediction[0])


















