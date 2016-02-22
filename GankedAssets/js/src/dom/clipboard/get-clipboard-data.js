/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {{clipboardData: DataTransfer}} event
 * @param {string} mime
 */
export function getClipboardData(event, mime = 'text/plain') {
    try {
        return event.clipboardData.getData(mime);
    } catch (e) {
        return '';
    }
}