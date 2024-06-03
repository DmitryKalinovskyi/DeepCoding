# Use the official Python image from the Docker Hub
FROM python:3.9-slim

# Set the working directory inside the container
WORKDIR /app

# Copy the Python script into the container
COPY runner.py .

# Define the command to run the script
ENTRYPOINT ["python3", "runner.py"]
