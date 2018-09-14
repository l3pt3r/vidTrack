//============================ Move Avatars function ============================
function moveAvatars() {
    for (avcnt = 0; avcnt < avatars.length; avcnt++) {
        if (poscnt < jsondata.Players[0].x.length - 1) {
            posx = (jsondata.Players[avcnt].x[poscnt + 1] - Dx) - (jsondata.Players[avcnt].x[poscnt] - Dx);
            posz = (jsondata.Players[avcnt].z[poscnt + 1] - Dz) - (jsondata.Players[avcnt].z[poscnt] - Dz);
            avatars[avcnt].translateX(-posz);
            avatars[avcnt].translateZ(posx);
            poscnt++;
        }
    }
}