/**
 * (c) 2015 Ganked
 */

/**
 *
 * @param {HTMLElement} $scope
 * @param {string} selector
 * @return {HTMLElementCollection}
 */
export function selectInScope($scope, selector) {
    return $scope.querySelector(selector) ||
        $scope.parentNode.querySelector(selector) ||
        $scope.ownerDocument.querySelector(selector);
}