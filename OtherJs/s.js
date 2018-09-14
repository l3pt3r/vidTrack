function loadTracker(fr, fg, fb) {

    tracking.ColorTracker.registerColor('custom', function (r, g, b) {
        var dx = r - fr;
        var dy = g - fg;
        var dz = b - fb;

        if ((b - g) >= 100 && (r - g) >= 60) {
            return true;
        }
        return dx * dx + dy * dy + dz * dz < 3500;
    });

    var tracker = new tracking.ColorTracker(['custom']);
    tracker.setMinDimension(1);

    tracking.track(v, tracker);

    tracker.on('track', function (event) {
        data = [];

        ctx.clearRect(0, 0, c.width, c.height);

        ctx.drawImage(v, 0, 0, c.width, c.height);

        event.data.forEach(function (rect) {
            data.push(rect);
        });

        try {

            index = 0;
            // height = 50;
            // width = 50;

            frect = [];
            frect.x = cx;
            frect.y = cy;
            frect.height = height;
            frect.width = width;

            if (data[0].color === 'custom') {
                data[0].color = tracker.customColor;
            }

            ctx.strokeStyle = data[0].color;
            ctx.strokeRect(frect.x, frect.y, frect.width, frect.height);
            ctx.font = '11px Helvetica';
            ctx.fillStyle = "#fff";
            ctx.fillText('x: ' + frect.x + 'px', frect.x + frect.width, frect.y);
            ctx.fillText('y: ' + frect.y + 'px', frect.x + frect.height, frect.y);

            while (index + 1 < data.length) {

                cdata = []
                cdata.push(data[index]);

                for (i = index + 1; i < data.length; i++) {

                    if (data[i].x - data[i - 1].x <= width && data[i].y - data[i - 1].y <= height) {
                        cdata.push(data[i]);
                    } else {
                        break;
                    }

                }

                index = i + 1;
                //rect = mergeAll(cdata)[0];

                if (frect.x - rect.x <= width && frect.y - rect.y <= height) {
                    rect.color = "#2a3a3a";

                    rect["width"] = "50";
                    rect["height"] = "50";

                    if (rect.color === 'custom') {
                        rect.color = tracker.customColor;
                    }

                    ctx.strokeStyle = rect.color;
                    ctx.strokeRect(rect.x, rect.y, rect.width, rect.height);
                    ctx.font = '11px Helvetica';
                    ctx.fillStyle = "#fff";
                    ctx.fillText('x: ' + rect.x + 'px', rect.x + rect.width, rect.y);
                    ctx.fillText('y: ' + rect.y + 'px', rect.x + rect.height, rect.y);
                    frect.x = rect.x;
                    frect.y = rect.y;
                    break;
                }
            }
        } catch (e) {
            data = "";
        }


    });

}