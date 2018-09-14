//load avatar model
function loadAvatar(sid) {
    player.load("models/player.json", function (obj) {
        avatar = new THREE.Mesh(obj.geometry, obj.material);
        // avatar.scale.x = avatar.scale.y = avatar.scale.z = 2;
        console.log("Avatar OK!!", avatar);
        loadField(sid);
    });
}

//load field model
function loadField(sid) {
    field.load("models/field.json", function (object) {
        scene.add(object);
        console.log("Field OK!!", object);
        loadJSON(sid);
    });
}

//load data json file 
function loadJSON(sid) {
    posdata.load('outputFile_' + sid + '.json',
        function (data) {
            console.log('Loaded: outputFile_' + sid + '.json');
            jsondata = JSON.parse(data);
            console.log(jsondata);

            for (var i = 0; i < jsondata.Players.length; i++) {
                var avinst = new THREE.Mesh(avatar.geometry, avatar.material);
                avinst.material[1].emissive.set(setRandomColor());
                avatars.push(avinst);
            }
            console.log(avatars);
        },

        // Function called when download progresses
        function (xhr) {
            console.log((xhr.loaded / xhr.total * 100) + '% loaded');
        },

        // Function called when download errors
        function (xhr) {
            console.error('An error happened');
        }
    );
}