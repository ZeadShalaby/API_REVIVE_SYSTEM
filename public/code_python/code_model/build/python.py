import pandas as pd
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



# todo Use pd.json_normalize to convert the JSON to a DataFrame
df = pd.json_normalize(json_data, 
                     meta=['name','age','city' ])

###########################################################################################################################################
###########################################################################################################################################
#? Use pd.json_normalize to convert the JSON to a DataFrame
# ?df = pd.json_normalize(data['books'], 
#?                     meta=['title', ['author', 'first_name'], ['author', 'last_name'], ['publisher', 'name'], ['publisher', 'location']])
#! Rename the columns for clarity
#? df.columns = ['Title', 'Author_First_Name', 'Author_Last_Name', 'Publisher_Name', 'Publisher_Location']
###########################################################################################################################################
###########################################################################################################################################


#! Process the data
print("Finally Welcome Laravel")
print("")

# todo Do something with the data
print(json_data)
print("")

print("Dataframe")
print("")

# todo Display the DataFrame
print(df)
