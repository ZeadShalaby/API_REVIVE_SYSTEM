import sys
import json

#! Read data from PHP through stdin
data = sys.stdin.read()


#! Parse Json Data
data_dict = json.loads(data)



#! Process the data
print('Test weather its good or not')
print(data_dict)