/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { getJSONAttribute } from '../dom/get-json-attribute';
import { parseFragment } from '../dom/parse-fragment';
import Symbol from 'es6-symbol';
import d3 from 'd3';
import { getTimeout } from '../timers/get-timeout';

/**
 *
 * @type {Array}
 */
const blueColorPalette = [ '#48b0e4', '#5fbae7', '#a2d7f1' ];

/**
 *
 * @type {Array}
 */
const redGreenColorPalette = [ '#2ecc71', '#e74c3c' ];

/**
 *
 * @param {string} name
 */
function getColorPalette(name) {
    if (name === 'red-green') {
        return redGreenColorPalette;
    }

    return blueColorPalette;
}

class PieChart extends CoreElement {
    createdCallback() {
        this.render();
    }

    /**
     *
     * @returns {boolean}
     */
    get donut() {
        return this.hasAttribute('donut');
    }

    /**
     *
     * @returns {boolean}
     */
    get showLabel() {
        return this.hasAttribute('show-label');
    }

    /**
     *
     * @returns {string}
     */
    get innerValue() {
        return this.getAttribute('inner-value') || 'sum';
    }

    /**
     * @returns {string}
     */
    get colorPalette() {
        return this.getAttribute('color-palette') || 'default';
    }

    /**
     * @returns {number}
     */
    get innerRadius() {
        return Number(this.getAttribute('inner-radius')) || 0.6;
    }

    /**
     *
     * @returns {Number}
     */
    get donutWidth() {
        return parseFloat(this.getAttribute('donut-width'));
    }

    /**
     *
     * @returns {Array}
     * @todo rename to values
     */
    get series() {
        return getJSONAttribute(this, 'series', []);
    }

    /**
     *
     * @returns {Array}
     */
    get labels() {
        return getJSONAttribute(this, 'labels', []);
    }

    /**
     *
     * @returns {string}
     */
    get unit() {
        return this.getAttribute('unit');
    }

    /**
     * Forces the element to re-render.
     *
     * @internal
     */
    render() {
        let radius, $svg, pie, arc, color, halfWidth, halfHeight, innerValue, innerValueFn, offset, sum;

        this.innerHTML = '';

        radius = Math.min(this.size, this.size) / 2;
        color = d3.scale.ordinal().range(getColorPalette(this.colorPalette));
        pie = d3.layout.pie().sort(null);
        arc = d3.svg.arc().outerRadius(radius).innerRadius(radius * this.innerRadius);
        halfWidth = this.size / 2;
        halfHeight = this.size / 2;
        offset = 100;

        if (this.labels.length === 0) {
            offset = 0;
        }

        innerValueFn = (a, b) => a + b;
        sum = this.series.reduce(innerValueFn);

        if (this.innerValue === 'fraction') {
            innerValueFn = (a, b) => a / b;
        }

        innerValue = Math.round(this.series.reduce(innerValueFn) * 10) / 10;

        if (this.unit) {
            innerValue += ' ' + this.unit;
        }

        $svg = this.$
            .append('svg')
            .attr('width', this.size + offset * 2)
            .attr('height', this.size + offset * 2);

        let arcs = $svg.selectAll('g')
            .data(pie(this.series.filter(n => 100 / sum * n > 1)))
            .enter().append('svg:g')
            .attr('transform', `translate(${halfWidth + offset}, ${halfHeight + offset})`);

        arcs.append('svg:path')
            .attr('fill', (_, i) => color(i))
            .transition()
            .duration(1000)
            .attrTween('d', finish => {
                let start = { startAngle: 0, endAngle: 0 },
                    i = d3.interpolate(start, finish);

                return (d) => arc(i(d));
            });

        arcs.append("text")
            .each(d => { d.angle = (d.startAngle + d.endAngle) / 2; })
            .attr('class', 'smalltext')
            .attr('dy', '.35em')
            .style('opacity', 0)
            .style('text-anchor', d => d.angle > Math.PI ? "end" : null)
            .attr("transform", function(d) {
                return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")" + "translate(" + (radius + 10) + ")" + (d.angle > Math.PI ? "rotate(180)" : "");
            })
            .text((d, i) => { return this.labels[i]; })
            .transition()
            .duration(1000)
            .style('opacity', 1);

        $svg.append('svg:g')
            .attr('transform', `translate(${halfWidth + offset}, ${halfHeight + offset})`)
            .append('svg:text')
            .attr('dy', '.35em')
            .attr('text-anchor', 'middle')
            .text(innerValue);
    }

    /**
     *
     * @returns {*}
     * @private
     */
    get $() {
        return d3.select(this);
    }

    /**
     *
     * @returns {*}
     */
    get $svg() {
        return this.$.select('svg');
    }

    /**
     *
     * @returns {number}
     */
    get size() {
        return Number(this.getAttribute('size')) || 170;
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('pie-chart', PieChart);
}
