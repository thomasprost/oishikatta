let log = function (value) {
    console.log(value)
}

let OISHI =  (function () {
    'use strict';


    let init = function () {
        console.log("init oishi")
    };

    return {
        init: init
    };
})();

export default OISHI;