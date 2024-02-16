import sys
import json

#! Read data from PHP through stdin
data = sys.stdin.read()


#! Parse Json Data
data_dict = json.loads(data)



#! Process the data
print("Trainng carbon_footprint for factory Ratio With Laravel")
print(data_dict )