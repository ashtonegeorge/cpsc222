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
	if request.method == 'POST':
		return {"0":"root","1":"daemon","2":"bin","3":"sys","4":"sync","5":"games","6":"man","7":"lp","8":"mail","9":"news","10":"uucp"}

@app.route("/api/group", methods=['POST'])
@auth.login_required
def group_list():
	if request.method == 'POST':
		return {'1': 'groupname1', '2': 'groupname2'}

@app.route("/")
def home():
	return "<iframe src='https://www.ashtonegeorge.com' style='width:100vw;height:100vh;margin:0;border:0;'>Ashton&apos;s Website</iframe>"

if __name__ == '__main__':
	app.run(host='127.0.0.1', port=8000)
