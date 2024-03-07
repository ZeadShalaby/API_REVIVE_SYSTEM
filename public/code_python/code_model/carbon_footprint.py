import json
import os

#! Get the directory of the current script
current_directory = os.path.dirname(os.path.abspath(__file__))

# !Get the base path by going up one directory
base_path = os.path.dirname(current_directory)
path = base_path+"\\json\\data.json"

#! Open the file for reading
with open(path, 'r') as file:
    # Read the JSON data from the file
    json_data = json.load(file)

#! Process the data
print("carbon_footprint for factory Ratio With Laravel")

# todo Do something with the data
print(json_data)