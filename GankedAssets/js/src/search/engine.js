/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

export class Engine {
    constructor() {
        /**
         *
         * @type {Map}
         */
        this.providers = new Map();

        /**
         *
         * @type {string}
         */
        this.query = '';
    }

    /**
     *
     * @param {string} name
     * @param {Provider} provider
     */
    addProvider(name, provider) {
        this.providers.set(name, provider);
    }

    /**
     * The callback is invoked every time a provider returns a result.
     *
     * @param {string} query
     * @param {Function} callbackFn
     */
    search(query, callbackFn) {
        this.query = query;

        if (/^[\s]*$/.test(query)) {
            return callbackFn({ query: query, items: [] });
        }

        this.providers.forEach((provider) => {
            provider.search(query).then((result) => {
                if (result.query === this.query) {
                    callbackFn(result);
                }
            });
        });
    }
}