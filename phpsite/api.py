from flask import Flask, request, jsonify
from flask_httpauth import HTTPBasicAuth

app = Flask(__name__)
auth = HTTPBasicAuth()

users = {
	"test": "abcABC123"
}

@auth.verify_password
def verify_password(username, password): # example login command: curl -u "username:password" -X POST https://ipaddress/api/
	print(username)
	print(password)
	if username in users and users.get(username) == password:
		return username

@app.route("/api/user", methods=['POST'])
@auth.login_required
def user_list():
	return list("/etc/passwd")

@app.route("/api/group", methods=['POST'])
@auth.login_required
def group_list():
        return list("/etc/group")

def list(path):
	if request.method == 'POST':
		dict = {}
		with open(path, "r") as file:
			for line in file:
				info_parts = line.strip().split(":")
				name = info_parts[0]
				id = info_parts[2]
				dict[id] = name
		return jsonify(dict)

@app.route("/")
def home():
	return "<iframe src='https://www.ashtonegeorge.com' style='width:100vw;height:100vh;margin:0;border:0;'>Ashton&apos;s Website</iframe>"

if __name__ == '__main__':
	app.run(host='127.0.0.1', port=8000)
