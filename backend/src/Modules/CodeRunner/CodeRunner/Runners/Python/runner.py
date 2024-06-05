import sys
import time
import tracemalloc
import contextlib
import io
import signal


is_processed = False
# Define a timeout handler
class TimeoutException(Exception):
    pass

def timeout_handler(signum, frame):
    if not is_processed:
        raise TimeoutException("Execution timed out")

# Set the timeout limit (in seconds)
TIMEOUT_LIMIT = 5  # Set your desired timeout limit here

# Read the code and input files
def read_file(filename):
    with open(filename, 'r') as file:
        return file.read()

code = read_file('/app/code.py')
input_data = read_file('/app/input.txt')

# Expected structure in case of exception
# Started
# .. garbage output
# Exception
# Exception description

# In case of executed
# Started
# Output
# Runtime: *ms
# Memory: *mb

print("Started")

# Redirect stdout to capture the output
output = io.StringIO()

# Set the timeout handler
signal.signal(signal.SIGALRM, timeout_handler)
signal.alarm(TIMEOUT_LIMIT)

try:
    start_time = time.time()  # Start time for execution
    tracemalloc.start()       # Start tracking memory

    # Backup the original stdin
    original_stdin = sys.stdin
    sys.stdin = io.StringIO(input_data)

    # Execute the code with the provided input, capturing the output
    with contextlib.redirect_stdout(output):
        exec(code)

    is_processed = True
    # Restore the original stdin
    sys.stdin = original_stdin

    end_time = time.time()    # End time for execution
    current, peak = tracemalloc.get_traced_memory()
    tracemalloc.stop()

    runtime = (end_time - start_time) * 1000  # Convert to milliseconds
    memory = peak / 1024 / 1024               # Convert to megabytes

    print("Output")
    print(output.getvalue())
    print(f"Runtime: {runtime:.2f}ms")
    print(f"Memory: {memory:.2f}mb")
except TimeoutException as te:
    print("Exception")
    print(str(te))
except Exception as e:
    print("Exception")
    print(str(e))
finally:
    signal.alarm(0)  # Disable the alarm
    output.close()
