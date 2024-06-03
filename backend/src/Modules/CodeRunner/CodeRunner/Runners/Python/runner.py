import sys

code = sys.argv[1] if len(sys.argv) > 1 else ""
print("Started")
try:
    exec(code)
except Exception as e:
    print("Exception")
    print(str(e))
