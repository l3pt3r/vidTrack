function binary() {
    /*
       To convert image into binary , we will threshold it.
       Based upon the threshold value
       thresh_red, thresh_blue, thresh_green ==> are the respective red, blue and green color threshold values. Any thing above this threshold value will be denoted by white color and anything below will be black
     */
    
    var image = ctx.getImageData(0, 0, c.width, c.height);
    var thresh_red = R;
    var thresh_green = G;
    var thresh_blue = B;

    var channels = image.data.length / 4;
    for (var i = 0; i < channels; i++) {
        var r = image.data[i * 4 + 0];
        var g = image.data[i * 4 + 1];
        var b = image.data[i * 4 + 2];
        if (r >= thresh_red && g == thresh_green && b >= thresh_blue) {
            image.data[i * 4 + 0] = 255;
            image.data[i * 4 + 1] = 255;
            image.data[i * 4 + 2] = 255;
        } else {
            image.data[i * 4 + 0] = 0;
            image.data[i * 4 + 1] = 0;
            image.data[i * 4 + 2] = 0;
        }
    }
    ctx2.putImageData(image, 0, 0);

}