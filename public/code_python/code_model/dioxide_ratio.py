import sys
import json

#! Read data from PHP through stdin
data = sys.stdin.read()


#! Parse Json Data
data_dict = json.loads(data)



#! Process the data
print("Dioxide Ratio With Laravel")
print(data_dict)