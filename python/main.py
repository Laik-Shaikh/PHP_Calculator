import sys
from numpy import sin, cos, tan
from math import pi, sqrt


# Function definitions
def solveExpression(param1):
    try:
        ans = eval(param1)
        return ans
    except ZeroDivisionError as e:
        print("Cannot be divided by 0")
    except:
        print("invalid syntax")
    


if len(sys.argv) >= 2:
    function_name = sys.argv[1]
    param1 = sys.argv[2]

    
    if function_name == "solveExpression":
        print(solveExpression(param1))
    
    else:
        print("Invalid function name.")
