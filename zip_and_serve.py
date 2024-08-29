# zip_and_serve.py

from flask import Flask, send_file, abort
import os
import zipfile

app = Flask(__name__)

# Directory where files are served
BASE_DIR = '/var/www/html'


@app.route('/<path:subpath>/zip', methods=['GET'])
def zip_files(subpath):
    dir_path = os.path.join(BASE_DIR, subpath.strip('/'))

    if not os.path.exists(dir_path) or not os.path.isdir(dir_path):
        return "Directory not found", 404

    zip_filename = '/tmp/dynamic_files.zip'

    with zipfile.ZipFile(zip_filename, 'w') as zipf:
        for root, dirs, files in os.walk(dir_path):
            for file in files:
                file_path = os.path.join(root, file)
                zipf.write(file_path, os.path.relpath(file_path, BASE_DIR))

    return send_file(zip_filename, as_attachment=True)


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
