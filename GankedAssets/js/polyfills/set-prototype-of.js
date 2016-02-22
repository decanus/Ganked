/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */
(function(){

    'use strict';

    if (typeof Object.setPrototypeOf === 'function') {
        return;
    }

    /**
     *
     * @param {object} obj
     * @param {object, null} prototype
     */
    Object.setPrototypeOf = function(obj, prototype) {
        if (typeof obj === 'object' && typeof prototype === 'object') {
            obj.__proto__ = prototype;
        }

        return obj;
    };
})();