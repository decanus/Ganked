/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { Provider } from './provider';
import { forOwn } from '../utils/for-own';
import champions from '../../../data/champions.json';
import Symbol from 'es6-symbol';

export class ChampionProvider extends Provider {
    /**
     *
     * @param {string} rawQuery
     * @param {Function} done
     */
    doSearch(rawQuery, done) {
        let results = [],
            query = rawQuery.toLowerCase(),
            order = Symbol('order');

        forOwn(champions, function(value, key){
            let indexOf = value.title.toLowerCase().indexOf(query);

            if (indexOf > -1) {
                value[order] = indexOf;

                results.push(value);
            }
        });

        results = results.sort((a, b) => {
            if(a[order] < b[order]) {
                return -1;
            }

            if (a[order] === b[order]) {
                return a.title.localeCompare(b.title);
            }

            return 1;
        });

        done(results.slice(0, 4));
    }
}
