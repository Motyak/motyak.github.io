
SHELL := /bin/bash
.SHELLFLAGS := -o errexit -o pipefail -c

BOOKS := book

HTML_BOOKS := $(BOOKS:%=monlang/%.html)
TXT_BOOKS := $(BOOKS:%=monlang/%.txt)
BOOK_DEPS := $(BOOKS:%=.deps/%.d)

.PHONY: all
all: $(HTML_BOOKS) $(TXT_BOOKS)

$(HTML_BOOKS): monlang/%.html: data/book/%.php .deps/%.d build/node_modules
	build/preprocess.php $< | build/preprocess.js > $@

$(TXT_BOOKS): monlang/%.txt: data/book/%.php .deps/%.d build/node_modules
	build/preprocess.php $< | build/to_text.js > $@

$(BOOK_DEPS): .deps/%.d: data/book/%.php
	php build/get_deps.php $< > $@

build/node_modules: build/package.json
	npm install --prefix build/
	@touch $@

-include $(BOOK_DEPS)

# will create all necessary directories after the Makefile is parsed
$(if $(filter .DEFAULT,$(MAKECMDGOALS)),,$(shell mkdir -p .deps))

.DELETE_ON_ERROR:
