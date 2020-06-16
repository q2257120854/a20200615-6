Component({
    externalClasses: [ "i-class" ],
    relations: {
        "../cell/index": {
            type: "child",
            linked: function() {
                this._updateIsLastCell();
            },
            linkChanged: function() {
                this._updateIsLastCell();
            },
            unlinked: function() {
                this._updateIsLastCell();
            }
        }
    },
    methods: {
        _updateIsLastCell: function() {
            var e = this.getRelationNodes("../cell/index"), t = e.length;
            if (t > 0) {
                var l = t - 1;
                e.forEach(function(e, t) {
                    e.updateIsLastCell(t === l);
                });
            }
        }
    }
});