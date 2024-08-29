FROM python:3.9-slim

ENV PYTHONUNBUFFERED=1

RUN apt-get update \
    && apt-get install -y \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /usr/src/app

RUN pip install Flask
COPY zip_and_serve.py .

EXPOSE 5000

CMD ["python", "zip_and_serve.py"]
