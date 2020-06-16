var e = require("../../@babel/runtime/helpers/interopRequireDefault")(require("../../@babel/runtime/helpers/typeof")), t = function(e, t) {
    console.warn(e), console.log("接受到的值为：", t);
};

Component({
    externalClasses: [ "i-class" ],
    options: {
        multipleSlots: !0
    },
    relations: {
        "../cell-group/index": {
            type: "parent"
        }
    },
    properties: {
        title: {
            type: String
        },
        label: {
            type: String
        },
        value: {
            type: String
        },
        onlyTapFooter: {
            type: Boolean
        },
        isLink: {
            type: null,
            value: ""
        },
        linkType: {
            type: String,
            value: "navigateTo"
        },
        url: {
            type: String,
            value: ""
        }
    },
    data: {
        isLastCell: !0
    },
    methods: {
        navigateTo: function() {
            var i = this.data.url, a = (0, e.default)(this.data.isLink);
            this.triggerEvent("click", {}), this.data.isLink && i && "true" !== i && "false" !== i && ("boolean" === a || "string" === a ? -1 !== [ "navigateTo", "redirectTo", "switchTab", "reLaunch" ].indexOf(this.data.linkType) ? wx[this.data.linkType].call(wx, {
                url: i
            }) : t("linkType 属性可选值为 navigateTo，redirectTo，switchTab，reLaunch", this.data.linkType) : t("isLink 属性值必须是一个字符串或布尔值", this.data.isLink));
        },
        handleTap: function() {
            this.data.onlyTapFooter || this.navigateTo();
        },
        updateIsLastCell: function(e) {
            this.setData({
                isLastCell: e
            });
        }
    }
});