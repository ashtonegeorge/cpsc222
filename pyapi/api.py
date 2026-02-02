from flask import Flask
from flask_restful import Api, reqparse, Resource 

app = Flask(__name__)
api = Api(app)

user_args = reqparse.RequestParser()
user_args.add_argument('username', type=str, required=True, help="Name cannot be blank", location='args')
user_args.add_argument('password', type=str, required=True, help="Password cannot be blank", location='args')

class User(Resource):
	def get(self):
		args = user_args.parse_args()	
		if(args.get('username') != 'test' and args.get('password') != 'abcABC123'):
			abort(401, message="Incorrect credentials")
		return {"0":"root","1":"daemon","2":"bin","3":"sys","4":"sync","5":"games","6":"man","7":"lp","8":"mail","9":"news","10":"uucp","13":"proxy","33":"www-data","34":"backup","38":"list","39":"irc","41":"gnats","100":"systemd-network","101":"systemd-resolve","102":"messagebus","103":"systemd-timesync","104":"syslog","105":"_apt","106":"tss","107":"uuidd","108":"systemd-oom","109":"tcpdump","110":"avahi-autoipd","111":"usbmux","112":"dnsmasq","113":"kernoops","114":"avahi","115":"cups-pk-helper","116":"rtkit","117":"whoopsie","118":"sssd","119":"speech-dispatcher","120":"nm-openvpn","121":"saned","122":"colord","123":"geoclue","124":"pulse","125":"gnome-initial-setup","126":"hplip","127":"gdm","128":"ntp","129":"_rpc","130":"statd","131":"Debian-snmp","132":"telnetd","133":"mysql","134":"mongodb","135":"sshd","136":"fwupd-refresh","1000":"slonkak","1001":"sshuser","65534":"nobody","524288":"snapd-range-524288-root","584788":"snap_daemon"}

class Group(Resource):
	def get(self):
		args = user_args.parse_args()	
		if(args.get('username') != 'test' and args.get('password') != 'abcABC123'):
			abort(401, message="Incorrect credentials")
		return {'1': 'groupname1', '2': 'groupname2'} 

api.add_resource(User, '/api/user')
api.add_resource(Group, '/api/group')

#@app.route('/')
#def home():
#	return "<h1>Ashton's Rest API</h1>"

if __name__ == '__main__':
	app.run(debug=True)




