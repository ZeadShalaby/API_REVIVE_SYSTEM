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


data=pd.DataFrame(df,columns=['co','co2','o2','degree','humidity','created_at'])
path = New_base_path+"\\images\\machine\\data"
#  # # # # # # #Function to generate visualization based on stored data
def visualization():

    plt.figure(figsize=(10, 6))
    sns.set_style("darkgrid")
    data.set_index('created_at').plot(marker='o')
    plt.title('Measurement Of Gases Per Time',fontsize=14)
    plt.xlabel('Time')
    plt.legend(title='Gases')
    plt.xticks(rotation=25)
    static_image_path = os.path.join(os.getcwd(), path, 'user_analysis.png')
    plt.savefig(static_image_path)
    plt.close()
    ######################### scatter Plots
    df = data.drop(['degree','created_at'], axis=1)
    # Plotting
    plt.figure(figsize=(12, 8))
    sns.set_style("darkgrid")
    for column in df.columns[:-1]:
        plt.scatter(df['humidity'], df[column], label=column)
    plt.title('correlation between gases and humidity', fontsize=25)
    plt.xlabel('humidity', fontsize=20)
    plt.legend()
    static_image_path = os.path.join(os.getcwd(), path, 'user2_analysis.png')
    plt.savefig(static_image_path)
    plt.close()
    #########################################
    df = data.drop(['humidity','created_at'], axis=1)
    plt.figure(figsize=(12, 8))
    sns.set_style("darkgrid")
    for column in df.columns[:-1]:
        plt.scatter(df['degree'], df[column], label=column)
    plt.title('correlation between gases and Temperature',fontsize=25)
    plt.xlabel('Temperature', fontsize=20)
    plt.legend()
    static_image_path = os.path.join(os.getcwd(), path, 'user3_analysis.png')
    plt.savefig(static_image_path)
    plt.close()
    print("Visualization has been updated.")
    print("/api/rev/images/reviveimagemachine/data/user_analysis.png")
    print("/api/rev/images/reviveimagemachine/data/user2_analysis.png")
    print("/api/rev/images/reviveimagemachine/data/user3_analysis.png")


#############################################
visualization()
print()
print(data)

