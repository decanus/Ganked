#
# (c) 2015 Ganked
#

ROOT_DIR:=$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

PATH := $(ROOT_DIR)/node_modules/.bin:$(ROOT_DIR)/bin:/usr/local/bin:$(PATH)
SHELL := /bin/bash

.PHONY: all clean install test watch indexes

scss_source := $(shell find scss -name "*.scss")
polyfills_source := bower_components/fetch/fetch.js \
					bower_components/picturefill/dist/picturefill.min.js \
					bower_components/webcomponentsjs/CustomElements.js \
					bower_components/time-elements/time-elements.js \
					bower_components/Array.from/array-from.js \
					js/polyfills/*.js

champ_images_dir := images/lol/champion/splash
champ_images := $(wildcard $(champ_images_dir)/*_0.jpg)

champ_img_small := $(subst /splash/,/splash/thumbnail/small/, $(champ_images))
champ_img_medium := $(subst /splash/,/splash/thumbnail/medium/, $(champ_images))
champ_img_large := $(subst /splash/,/splash/thumbnail/large/, $(champ_images))

tier_images_dir := images/lol/tier
tier_images := $(wildcard $(tier_images_dir)/*.png)
tier_images_small := $(subst /tier/,/tier/small/, $(tier_images))

achievement_dir := images/csgo/achievements
achievement_images := $(wildcard $(achievement_dir)/*.jpg)
achievement_images_bw := $(subst /achievements/,/achievements/bw/, $(achievement_images))

js_source := $(shell find js/src -name '*.js')

js_test_src := $(shell find test/src -name '*.js')
js_test_out := $(subst test/src/,test/build/, $(js_test_src))
app_bundle := css/style.css css/maintenance.css js/timeline-worker.js js/polyfills.js js/ganked.js $(champ_img_small) $(champ_img_medium) $(champ_img_large) $(tier_images_small) $(achievement_images_bw)
deps := node_modules bower_components
thumbnail_source := $(shell find images/lol/champion/splash -type f -name "*_0.jpg" -maxdepth 1 -type f)

all: $(deps) $(app_bundle)
clean:
	rm -rf $(app_bundle) .sass-cache test/build/ test/index.html

test: css/style.css $(deps) $(js_test_out) test/index.html
	jshint js/src
	mocha-phantomjs test/index.html

test/index.html: $(js_test_out) test/src/index.html js/polyfills.js
	build-test-html.sh $(js_test_out) < test/src/index.html > $@

test/build/%.js: test/src/%.js
	mkdir -p $(dir $@)
	browserify $< --transform babelify > $@

watch: $(deps)
	watch make scss/ js/src/

indexes:
	generate-index.sh scss

css/style.css: $(scss_source)
	mkdir -p $(dir $@)
	sass scss/style.scss:$@ --style=compressed --sourcemap=none
	postcss --use autoprefixer $@ -d $(dir $@)

css/maintenance.css: $(scss_source)
	mkdir -p $(dir $@)
	sass scss/style.scss:$@ --style=compressed --sourcemap=none
	postcss --use autoprefixer $@ -d $(dir $@)

bower_components/: bower.json
	bower install

node_modules/: package.json
	npm install

js/polyfills.js: $(polyfills_source)
	node node_modules/.bin/concat-cli -f $(polyfills_source) -o $@
	uglifyjs $@ -o $@

js/ganked.js: $(js_source)
	browserify js/src/ganked.js -d --transform babelify | exorcist js/ganked.js.map > js/ganked.js
	uglifyjs js/ganked.js -o $@ --in-source-map js/ganked.js.map --source-map js/ganked.js.map --source-map-url //cdn.ganked.net/js/ganked.js.map --source-map-include-sources

js/timeline-worker.js: $(js_source)
	browserify js/src/workers/timeline.js --transform babelify | uglifyjs -o $@

$(champ_images_dir)/thumbnail/small/%.jpg: $(champ_images_dir)/%.jpg
	mkdir -p $(dir $@)
	convert -resize 255x255 $< $@
	jpegoptim --strip-all $@

$(champ_images_dir)/thumbnail/medium/%.jpg: $(champ_images_dir)/%.jpg
	mkdir -p $(dir $@)
	convert -resize 385x385 $< $@
	jpegoptim --strip-all $@

$(champ_images_dir)/thumbnail/large/%.jpg: $(champ_images_dir)/%.jpg
	mkdir -p $(dir $@)
	convert -resize 515x515 $< $@
	jpegoptim --strip-all $@

$(tier_images_dir)/small/%.png: $(tier_images_dir)/%.png
	mkdir -p $(dir $@)
	convert -resize 54x54 $< $@
	optipng $@

$(achievement_dir)/bw/%.jpg: $(achievement_dir)/%.jpg
	mkdir -p $(dir $@)
	convert -type Grayscale $< $@
	jpegoptim --strip-all $@