/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

let text = ' _____             _            _ \n|  __ \\           | |          | |\n| |  \\/ __ _ _ __ | | _____  __| |\n| | __ / _` | \'_ \\| |/ / _ \\/ _` |\n| |_\\ \\ (_| | | | |   <  __/ (_| |\n \\____/\\__,_|_| |_|_|\\_\\___|\\__,_|';

class Lie {
    /**
     *
     * @returns {boolean}
     */
    valueOf() {
        return false;
    }

    /**
     *
     * @returns {string}
     */
    toString() {
        return `It's a lie!`;
    }
}

/**
 *
 * @param {{}} factory
 */
export default function(factory) {
    console.log(text);

    Object.defineProperty(factory, 'cake', {
        get: function(){
            console.error(['The', 'cake', 'is', 'a', 'lie!', 'You', 'know', 'it', 'is!'].join(' '));
            console.error(`Why would you ever trust me?`);

            return new Lie();
        }
    });

    factory.Lie = Lie;
}