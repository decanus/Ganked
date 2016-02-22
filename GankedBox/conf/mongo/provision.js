var mongo = new Mongo(),
    db = mongo.getDB('ganked');

db.createUser({
    user: 'ourMongo',
    pwd: 'mongolisch',
    roles: []
});