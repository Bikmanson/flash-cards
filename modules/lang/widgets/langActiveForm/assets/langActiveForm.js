var LangActiveForm = function () {
    var form, defaultLangInd, langDropdown, settings;
    var langAttributes = []; //each language attributes object
    var removedValidationLangs = [];
    var script = (document.currentScript !== undefined) ? $(document.currentScript) : $("script:last"); //get script obj
    //trigger visibility of lang fields
    function showFields(langInd) {
        for (var l = 0; l < langAttributes.length; l++) {
            if (l === parseInt(langInd))
                for (var i = 0; i < langAttributes[l].length; i++)
                    $(langAttributes[l][i].container).css('display', 'block');
            else
                for (var a = 0; a < langAttributes[l].length; a++)
                    $(langAttributes[l][a].container).css('display', 'none');
        }
    }

    function removeErrorAndContainerCss(lang) {
        for (var i = 0; i < langAttributes[lang].length; i++) {
            var container = form.find(langAttributes[lang][i].container);
            var error = container.find(langAttributes[lang][i].error);
            error.empty();
            container.removeClass(settings.validatingCssClass + ' ' + settings.errorCssClass + ' ' + settings.successCssClass);
        }
    }

    //remove validation for lang attributes
    function removeValidation(lang) {
        for (var i = 0; i < langAttributes[lang].length; i++) {
            if (form.yiiActiveForm('find', langAttributes[lang][i]['id']) !== undefined) {
                form.yiiActiveForm('remove', langAttributes[lang][i]['id']);
            }
        }
    }

    //add validation for lang attributes
    function addValidation(lang) {
        for (var i = 0; i < langAttributes[lang].length; i++) {
            if (form.yiiActiveForm('find', langAttributes[lang][i]['id']) === undefined) {
                form.yiiActiveForm('add', langAttributes[lang][i]);
            }
        }
    }

    function isEmpty(value) {
        if (typeof value == 'string' || value instanceof String)
            value = $.trim(value);
        return value === null || value === undefined || value === '' || ($.isArray(value) && value.length === 0);
    }

    //check empty lang fields
    function isLangEmpty(lang) {
        for (var i = 0; i < langAttributes[lang].length; i++) {
            if (!isEmpty($(langAttributes[lang][i].input).val()))
                return false;
        }
        return true;
    }

    //get lang index by attribute id
    function getAttributesLangIndex(attribute) {
        var l = $(attribute.container).data("langind");
        if (l === undefined) {
            return false;
        }
        var ind = parseInt(l);
        if (isNaN(ind)) {
            return false;
        }
        return ind;
    }

    //get lang name by lang index
    function getLangNameByInd(ind) {
        return langDropdown.find("option[value='" + ind + "']").text();
    }

    //init attributes array
    function initLangAttributes() {
        var attributes = form.yiiActiveForm("data").attributes;
        langAttributes = [];
        for (var i = 0; i < attributes.length; i++) {
            var ind = $(attributes[i].container).data('langind');
            if (ind !== undefined) {
                if (langAttributes[ind] !== undefined) { //if langAttributes have language
                    langAttributes[ind][langAttributes[ind].length] = attributes[i];
                } else {
                    langAttributes[ind] = [attributes[i]];
                }
            }
        }
    }

    //register form validation events
    function registerEvents() {
        form.on('beforeValidateAttribute', function (event, attribute, messages) {
            var ind = getAttributesLangIndex(attribute); //get language index
            if (ind !== false && ind !== defaultLangInd) {
                if (isLangEmpty(ind)) {
                    removeErrorAndContainerCss(ind);
                    return false;
                }
            }
        });
        form.on('beforeValidate', function (e) {
            removedValidationLangs = [];
            for (var l = 0; l < langAttributes.length; l++) {
                if (l !== defaultLangInd) {
                    if (isLangEmpty(l)) {
                        removeValidation(l);
                        removedValidationLangs.push(l);
                    } else {
                        addValidation(l);
                    }
                }
            }
        });
        form.on('afterValidate', function (event, messages, errorAttributes) {
            if (errorAttributes.length > 0) {
                for (var i = 0; i < errorAttributes.length; i++) {
                    var id = errorAttributes[i].id;
                    var ind = getAttributesLangIndex(errorAttributes[i]);
                    if (ind !== false) {
                        messages[id][0] = messages[id][0] + " (" + getLangNameByInd(ind) + ")"; //add language name to error message in summary
                    }
                }
                for (var j = 0; j < removedValidationLangs.length; j++) {
                    addValidation(removedValidationLangs[j]);
                }
            }
        });
    }

    var dynamicFormEventHandler = function(e, item) {
        initLangAttributes();
        var langInd = langDropdown.val();
        showFields(langInd);
        dynamicformEvent();
    };

    function dynamicformEvent() {
        $("[data-dynamicform^='dynamicform_']")
            .off("afterInsert", dynamicFormEventHandler)
            .on("afterInsert", dynamicFormEventHandler);
    }

    return {
        defaultLangInd: function() {
            return defaultLangInd;
        },
        notEmptyLangs: function () {
            if (langDropdown === undefined)
                this.init();
            var arr = [];
            for (var i = 0; i < langAttributes.length; i++) {
                if (!isLangEmpty(i))
                    arr.push(i);
            }
            return arr;
        },
        init: function () {
            langDropdown = $('#lang-dropdown');
            if (langDropdown.length > 0) {
                //init variables
                var formId = script.data("formid"); //get form id
                form = $('#' + formId); //get form tag
                defaultLangInd = script.data("deflangind"); //init default language
                settings = form.yiiActiveForm("data").settings; //yiiActiveForm settings
                initLangAttributes(); //get all translation attributes and init langAttributes array
                registerEvents(); //register validation events
                //show fields
                var langInd = langDropdown.val(); //currentLangInd = parseInt(langInd);
                showFields(langInd);
                langDropdown.change(function (e) {
                    var langInd = e.target.value;
                    showFields(langInd);
                });
                dynamicformEvent();
            }
        }
    };
}();


jQuery(document).ready(function ($) {
    LangActiveForm.init();
});