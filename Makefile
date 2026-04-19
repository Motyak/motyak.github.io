
SHELL := /bin/bash
.SHELLFLAGS := -o errexit -o pipefail -c

BOOKS := book
HTML_BOOKS := $(BOOKS:%=monlang/%.html)
TXT_BOOKS := $(BOOKS:%=monlang/%.txt)

.PHONY: all
all: $(HTML_BOOKS) $(TXT_BOOKS)

build/node_modules: build/package.json
	npm install --prefix build/

$(HTML_BOOKS): monlang/%.html: data/book/%.php build/node_modules
	build/preprocess.php $< | build/preprocess.js > $@

$(TXT_BOOKS): monlang/%.txt: data/book/%.php build/node_modules
	build/preprocess.php $< | build/to_text.js > $@

.DELETE_ON_ERROR:
