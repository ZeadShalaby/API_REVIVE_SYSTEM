import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
import os
import json
import sys

#! Get the directory of the current script
current_directory = os.path.dirname(os.path.abspath(__file__))

# !Get the base path by going up one directory
base_path = os.path.dirname(current_directory)
path = base_path+"\\json\\data.json"
# Remove 'code_python' from the base path
New_base_path = base_path.replace("\\code_python", "")


#! Open the file for reading
with open(path, 'r') as file:
    # Read the JSON data from the file
    json_data = json.load(file)


# todo Use pd.json_normalize to convert the JSON to a DataFrame
df = pd.json_normalize(json_data)
df['created_at'] = pd.to_datetime(df['created_at']).dt.date



###################################


data=pd.DataFrame(df,columns=['carbon_footprint','created_at'])
path = New_base_path+"\\images\\machine\\person"
#  # # # # # # #Function to generate visualization based on stored data
def visualization(data):
    sns.set_style("darkgrid")
    data.set_index('created_at').plot(marker='o',color='Springgreen')
    plt.title('Carbon Footprint Changes Over Time', fontsize=14)
    plt.xlabel('Date',fontsize=14,rotation=25)
    plt.ylabel('Value',fontsize=14)
    plt.xticks(rotation=25)
    static_image_path = os.path.join(os.getcwd(), path, 'person_analysis.png')
    plt.savefig(static_image_path)
    print("/api/rev/images/reviveimagemachine/person/person_analysis.png")
    plt.close()
#############################################
visualization(data)

print()
print(data)