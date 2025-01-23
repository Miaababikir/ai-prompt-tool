# Deployment Guide for Laravel Applications on AWS EC2 with Docker

This guide provides a detailed walkthrough of deploying Laravel applications using Docker containers on an AWS EC2 instance. It outlines the technologies used and the manual steps for setting up and managing the deployment.

## 1. Deployment Overview

The deployment uses a simple and straightforward setup:

- **AWS EC2 instance** as the hosting environment.

- **Docker containers** to encapsulate application services.

- **Manual deployment process**, pulling changes directly from Git via SSH.

- **Nginx** configured to serve two applications:

    - Coaching platform on port 80.

    - Prompt tool on port 81.


## 2. Tech Stack

### Docker Containers

- **MySQL**: Database server for storing application data.

- **PHP-FPM**: PHP FastCGI Process Manager for processing PHP scripts.

- **Nginx**: Web server to handle HTTP requests.

- **PHP Workers**: Background job processing using Supervisor.


### Other Technologies

- **Ubuntu**: Operating system for the EC2 instance.

- **Laradock**: A pre-configured Docker Compose setup for Laravel applications.


## 3. Why Laradock?

Laradock simplifies the deployment process by providing:

- A pre-configured `docker-compose.yml` file.

- Support for essential Laravel services (MySQL, PHP-FPM, Nginx, and more).

- Quick and consistent setup across different environments.

This approach was chosen to save time and ensure simplicity, enabling the task to be shipped as fast as possible. However, a more robust and scalable solution involves using CI/CD pipelines with GitHub Actions to build Docker components and push them to Amazon Elastic Container Registry (ECR). Amazon ECS can then be used to pull and deploy the updated containers automatically on the instances, streamlining the process and reducing manual intervention.

## 4. Deployment Steps

### Step 1: Set Up the EC2 Instance

1. **Launch an EC2 instance:**

    - Select Ubuntu as the AMI.

    - Configure the instance size and security groups (details below).

2. **Configure AWS Security Groups:**

    - Allow inbound traffic on ports 80 (coaching-platform) and 81 (ai-prompt-tool).

    - Allow SSH access on port 22 for deployment.

3. **Install Docker and Docker Compose:**


### Step 2: Clone the Application Code

1. **SSH into the EC2 instance:**

    ```
    ssh -i your-key.pem ubuntu@your-ec2-public-ip
    ```

2. **Clone the repository:**

    ```
    git clone https://github.com/your-repo.git
    ```

3. **Navigate to the project directory:**

    ```
    cd your-repo
    ```


### Step 3: Configure Laradock

1. **Clone the Laradock repository:**

    ```
    git clone https://github.com/laradock/laradock.git
    ```

2. **Copy the** `**.env**` **file:**

    ```
    cp env-example .env
    ```

3. **Modify the** `**.env**` **file** to match your application needs:

    - Set `APP_CODE_PATH_HOST` to the Laravel project directory.

    - Configure database credentials for MySQL.


### Step 4: Start Docker Containers

1. **Navigate to the Laradock directory:**

    ```
    cd laradock
    ```

2. **Build and start containers:**

    ```
    docker-compose up -d nginx mysql php-fpm workspace
    ```


### Step 5: Configure Nginx

1. **Update Nginx configuration:**

    - Modify the Nginx configuration file to handle both applications.

    - Example configuration for the coaching platform (port 80):

        ```
        server {
            listen 80;
            server_name your-domain.com;
        
            root /var/www/coaching-platform/public;
        
            index index.php index.html index.htm;
        
            location / {
                try_files $uri $uri/ /index.php?$query_string;
            }
        
            location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass php-fpm:9000;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
            }
        }
        ```

    - Similarly, configure port 81 for the AI Prompt Tool.

2. **Restart Nginx:**

    ```
    docker-compose exec nginx nginx -s reload
    ```


### Step 6: Set Up Workers for the AI Prompt Tool

1. **Configure Supervisor inside the PHP Workers container:**

    - Add a Supervisor configuration file for the AI Prompt Tool. Example configuration:

        ```
        [program:ai_prompt_tool_worker]
        command=php /var/www/ai-prompt-tool/artisan queue:work
        autostart=true
        autorestart=true
        stderr_logfile=/var/log/supervisor/ai_prompt_tool_worker.err.log
        stdout_logfile=/var/log/supervisor/ai_prompt_tool_worker.out.log
        ```

2. **Run the PHP-worker container**

### Step 7: Pull Updates from Git (Manual Deployment)

1. **SSH into the EC2 instance:**

    ```
    ssh -i your-key.pem ubuntu@your-ec2-public-ip
    ```

2. **Pull the latest changes:**

    ```
    cd /path/to/your-repo
    git pull origin main
    ```

3. **Restart the Docker containers if needed

## 5. Conclusion

This guide provides a complete manual process for deploying Laravel applications using Docker on AWS EC2. For production environments, consider automating these steps using CI/CD pipelines to streamline deployments and reduce manual effort.
