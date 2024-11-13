# My Project

This is a simple project that uses Docker.

## Prerequisites
- Docker installed on your machine. You can download it from [here](https://www.docker.com/get-started).

## Getting Started

### Clone the Repository
Clone this repository to your local machine using:
```bash
git clone https://github.com/BikkyS/ticketreservationapplication.git
cd ticketreservationapplication
docker build -t my-project-image .
docker run -d -p 8080:8080 --name my-project-container my-project-image
Access the Application
The application should now be running and accessible at http://localhost:8080.





