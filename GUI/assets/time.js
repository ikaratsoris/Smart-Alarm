function startTime() {
            var weekday = new Array(7);
            weekday[0]=  "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            var day = weekday[today.getDay()];
            var day_num = today.getDate();
            var month = today.getMonth();
            var year = today.getFullYear();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('time').innerHTML =
                h + ":" + m + ":" + s;
            document.getElementById('date').innerHTML =
                day + " " + day_num + " - " + month + " - " + year ;
            var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }