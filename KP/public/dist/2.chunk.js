webpackJsonp([2],{231:function(t,n,e){"use strict";function a(t){c||e(809)}Object.defineProperty(n,"__esModule",{value:!0});var i=e(439),r=e.n(i);for(var s in i)"default"!==s&&function(t){e.d(n,t,function(){return i[t]})}(s);var o=e(831),f=e.n(o),c=!1,p=e(1),d=a,u=p(r.a,f.a,!1,d,null,null);u.options.__file="src\\views\\note\\month\\staff_detail.vue",n.default=u.exports},315:function(t,n,e){var a=e(50),i=e(88),r=e(89),s=e(12),o=e(51),f=e(55),c={},p={},n=t.exports=function(t,n,e,d,u){var l,h,g,v,_=u?function(){return t}:f(t),k=a(e,d,n?2:1),x=0;if("function"!=typeof _)throw TypeError(t+" is not iterable!");if(r(_)){for(l=o(t.length);l>x;x++)if((v=n?k(s(h=t[x])[0],h[1]):k(t[x]))===c||v===p)return v}else for(g=_.call(t);!(h=g.next()).done;)if((v=i(g,k,h.value,n))===c||v===p)return v};n.BREAK=c,n.RETURN=p},439:function(t,n,e){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}function i(){var t=document.getElementsByClassName("tasks"),n=t.length;if(0!==n){for(var e=0;e<n;e++){0===(0,l.default)(".tasks").eq(e).find(".task").length?(0,l.default)(".departs").eq(e).hide():(0,l.default)(".departs").eq(e).show()}r()}}function r(){var t=(0,l.default)(".staff").length;if(0!==t)for(var n=0;n<t;n++){for(var e=0,a=(0,l.default)(".tasks").eq(n).find(".task").length,i=0;i<a;i++)e+=(0,l.default)(".tasks").eq(n).find(".task").eq(i)[0].offsetHeight;(0,l.default)(".staff")[n].style.height=e<120?"150px":e+60+"px"}}Object.defineProperty(n,"__esModule",{value:!0});var s=e(811),o=a(s),f=e(29),c=a(f),p=e(827),d=a(p),u=e(84),l=a(u);n.default={data:function(){return{formData:{mark:[],isMark:[],staffId:[],appraise:[],introduce:[]},markRange:[{min:96,max:100,appraise:"优秀",introduce:"A",tasks:[],active:"activeSuccess",is_task:[],number:[]},{min:90,max:95.9,appraise:"优良",introduce:"B",tasks:[],is_task:[],number:[]},{min:80,max:89.9,appraise:"合格",introduce:"C",tasks:[],is_task:[],number:[]},{min:60,max:79.9,appraise:"不足",introduce:"D",tasks:[],active:"activeError",is_task:[],number:[]},{min:1,max:59.9,appraise:"不合格",introduce:"E",tasks:[],active:"activeError",is_task:[],number:[]},{min:0,max:0,appraise:"未评价",introduce:"无",tasks:[],is_task:[],number:[]}],loading:!1,active:-1,date:"",tasks:[],taskNames:[],departStaffs:[],users:[],type:!0,finMark:[],isNotMark:[],attribute:[],taskMark:[],depart:"",staffSearch:""}},methods:{excelNoteMark:function(t){var n=this.date;"mark"===t?window.open("/api/note/excel?date="+n):"staff"===t&&window.open("/api/note/staff_excel?date="+n)},selectStaff:function(){var t=this;this.rangeClick(-1),(0,d.default)(this.departStaffs).forEach(function(n){if(""===t.staffSearch)return void n.staffs.forEach(function(e){t.$set(e,"is_task",!0),t.$set(n,"is_depart",!1)});t.$set(n,"is_depart",!0),(0,d.default)(t.departStaffs).forEach(function(n){console.log(t.staffSearch),n.staffs.forEach(function(e){e.staff===t.staffSearch?(t.$set(e,"is_task",!0),console.log(e),t.$set(n,"is_depart",!1)):(t.$set(e,"is_task",!1),console.log(e))})})})},selectDepart:function(){var t=this;this.rangeClick(-1),(0,d.default)(this.departStaffs).forEach(function(n){-1==t.depart?t.$set(n,"is_depart",!1):(t.$set(n,"is_depart",!0),t.depart==n.id&&t.$set(n,"is_depart",!1))})},rangeClick:function(t){var n=this;this.active=Number(t),this.tasks.forEach(function(e){e.staffs.forEach(function(e){n.markRange.forEach(function(a,i){if(a.min<=e.mark&&e.mark<=a.max)if(-1===t||i===t){var r=a.tasks[e.staff_id]||[];r.push(e),r=[].concat((0,c.default)(new o.default(r))),n.$set(a.is_task,e.staff_id,1),n.$set(a.tasks,e.staff_id,r)}else n.$set(a.is_task,e.staff_id,0)})})}),setTimeout(function(){i()},10)},goBack:function(){this.$router.push({name:"note-month"})},routeType:function(){this.$router.push({name:"note_task_detail",query:{date:this.date}})},getMarks:function(){var t=this;this.JAjax.postJson("staff/fin/mark",{date:this.date},function(n){t.finMark=n.data||[]})},getDepartStaffs:function(){var t=this;this.JAjax.postJson("note/depart/marks",{date:this.$route.query.date},function(n){t.departStaffs=n.data||[],t.init(),t.getMarks()})},init:function(){var t=this;this.date=this.$route.query.date,this.date?this.JAjax.postJson("note/staff/date",{date:this.date},function(n){t.tasks=n.data||[],t.attribute=n.attribute||[],t.isNotMark=n.isNotMark||[],t.taskMark=n.taskMark||[],t.tasks.forEach(function(n){n.staffs.forEach(function(n){t.markRange.forEach(function(e){if(e.min<=Number(n.mark)&&Number(n.mark)<=e.max){var a=e.tasks[n.staff_id]||[];a.push(n),t.$set(e.is_task,n.staff_id,1),t.$set(e.tasks,n.staff_id,a)}95.3===Number(n.mark)&&console.log(n.staff_id+"---"+n.task_id)})})}),t.taskNames=n.tasks||[];var e=(0,d.default)(t.departStaffs);e.forEach(function(n){(0,d.default)(e).forEach(function(n){t.markRange.forEach(function(t){t.tasks.length>0&&t.tasks.forEach(function(e,a){n.staffs.forEach(function(n){n.id===a&&(n.is_task=!0,t.number.push(a),t.number=[].concat((0,c.default)(new o.default(t.number))))})})})})})}):this.$Message.error("未选择时间")}},updated:function(){r()},mounted:function(){this.getDepartStaffs()}}},440:function(t,n,e){var a=e(11);t.exports=function(t,n,e){for(var i in n)e&&t[i]?t[i]=n[i]:a(t,i,n[i]);return t}},441:function(t,n){t.exports=function(t,n,e,a){if(!(t instanceof n)||void 0!==a&&a in t)throw TypeError(e+": incorrect invocation!");return t}},442:function(t,n,e){var a=e(17);t.exports=function(t,n){if(!a(t)||t._t!==n)throw TypeError("Incompatible receiver, "+n+" required!");return t}},809:function(t,n,e){var a=e(810);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);e(15)("531bef1a",a,!1,{})},810:function(t,n,e){n=t.exports=e(14)(!1),n.push([t.i,"\n.margin-top-8 {\n  margin-top: 8px;\n}\n.margin-top-10 {\n  margin-top: 10px;\n}\n.margin-top-20 {\n  margin-top: 20px;\n}\n.margin-left-10 {\n  margin-left: 10px;\n}\n.margin-bottom-10 {\n  margin-bottom: 10px;\n}\n.margin-bottom-100 {\n  margin-bottom: 100px;\n}\n.margin-right-10 {\n  margin-right: 10px;\n}\n.padding-left-6 {\n  padding-left: 6px;\n}\n.padding-left-8 {\n  padding-left: 5px;\n}\n.padding-left-10 {\n  padding-left: 10px;\n}\n.padding-left-20 {\n  padding-left: 20px;\n}\n.height-100 {\n  height: 100%;\n}\n.height-120px {\n  height: 100px;\n}\n.height-200px {\n  height: 200px;\n}\n.height-492px {\n  height: 492px;\n}\n.height-460px {\n  height: 460px;\n}\n.line-gray {\n  height: 0;\n  border-bottom: 2px solid #dcdcdc;\n}\n.notwrap {\n  word-break: keep-all;\n  white-space: nowrap;\n  overflow: hidden;\n  text-overflow: ellipsis;\n}\n.padding-left-5 {\n  padding-left: 10px;\n}\n[v-cloak] {\n  display: none;\n}\n.dragging-tip-enter-active {\n  opacity: 1;\n  transition: opacity .3s;\n}\n.dragging-tip-enter,\n.dragging-tip-leave-to {\n  opacity: 0;\n  transition: opacity 0.3s;\n}\n.dragging-tip-con {\n  display: block;\n  text-align: center;\n  width: 100%;\n  height: 50px;\n}\n.dragging-tip-con span {\n  font-size: 18px;\n}\n.record-tip-con {\n  display: block;\n  width: 100%;\n  height: 292px;\n  overflow: auto;\n}\n.record-item {\n  box-sizing: content-box;\n  display: block;\n  overflow: hidden;\n  height: 24px;\n  line-height: 24px;\n  padding: 8px 10px;\n  border-bottom: 1px dashed gainsboro;\n}\n.record-tip-con span {\n  font-size: 14px;\n}\n.edittable-test-con {\n  height: 160px;\n}\n.edittable-table-height-con {\n  height: 190px;\n}\n.edittable-con-1 {\n  box-sizing: content-box;\n  padding: 15px 0 0;\n  height: 196px;\n}\n.edittable-table-get-currentdata-con {\n  height: 190px !important;\n}\n.exportable-table-download-con1 {\n  padding: 16px 0 16px 20px;\n  border-bottom: 1px dashed #c3c3c3;\n  margin-bottom: 16px;\n}\n.exportable-table-download-con2 {\n  padding-left: 20px;\n}\n.show-image {\n  padding: 20px 0px;\n}\n.show-image img {\n  display: block;\n  width: 100%;\n  height: auto;\n}\n.searchable-table-con1 {\n  height: 230px !important;\n}\n.ivu-form-item-error-tip {\n  width: 200px;\n}\n.clear {\n  clear: both;\n}\n.title {\n  text-align: center;\n  font-weight: bold;\n  height: 50px;\n  line-height: 50px;\n  padding-left: 30px;\n  margin: -10px 0 10px 0;\n  background: #e6e6e6;\n}\n.depart {\n  text-align: center;\n  font-weight: bold;\n  height: 30;\n  line-height: 30px;\n  padding-left: 30px;\n  margin: -10px 0 10px 0;\n  background: #f4f4f4;\n}\n.departs {\n  margin-top: 10px;\n  clear: both;\n}\n.departs .staff {\n  width: 15%;\n  float: left;\n  position: relative;\n  text-align: center;\n  background: #d7d7d7;\n  margin-right: 1%;\n}\n.departs .staff div {\n  position: absolute;\n  width: 100%;\n  text-align: center;\n  -webkit-transform: translateY(-50%);\n          transform: translateY(-50%);\n  top: 50%;\n}\n.departs .staff span {\n  display: block;\n  height: 20px;\n}\n.departs .tasks {\n  min-height: 60px;\n  width: 84%;\n  float: left;\n}\n.departs .tasks .task:after {\n  content: '';\n  display: block;\n  clear: both;\n}\n.departs .tasks .task {\n  width: 100%;\n  line-height: 50px;\n  margin-bottom: 10px;\n}\n.departs .tasks .task:first-child {\n  margin-top: 20px;\n}\n.departs .tasks .task .appraise {\n  width: 6%;\n  float: left;\n  text-align: center;\n  background: #d7d7d7;\n}\n.departs .tasks .task .introduce {\n  border: 1px #999 solid;\n  margin-top: -1px;\n  width: 94%;\n  float: left;\n  padding-left: 10px;\n}\n.departs .tasks .task .introduce span {\n  display: inline-block;\n  height: 30px;\n  line-height: 30px;\n  background: #f4f4f4;\n  padding-left: 10px;\n  margin-right: 10px;\n}\n.details {\n  clear: both;\n  border: 1px #666666 solid;\n  border-top: none;\n  margin-top: -10px;\n  padding: 5px 10px;\n}\n.details > div {\n  margin-bottom: 10px;\n  line-height: 60px;\n  border: 1px #666666 solid;\n}\n.details > div .markRange {\n  display: inline-block;\n  width: 100px;\n  text-align: center;\n  background: #d7d7d7;\n  position: relative;\n  top: -1px;\n  left: -1px;\n}\n.details > div .span {\n  height: 35px;\n  line-height: 35px;\n  padding: 0 10px;\n  background: #f2f2f2;\n  margin: auto auto;\n  display: inline-block;\n  margin-left: 10px;\n}\nform .staff {\n  text-align: center;\n  line-height: 40px;\n  background: #f4f4f4;\n}\n.active {\n  background: #80cbfa;\n}\n.activeSuccess {\n  color: green;\n}\n.activeError {\n  color: red;\n}\n.taskDiv {\n  margin-bottom: 20px;\n}\n",""])},811:function(t,n,e){t.exports={default:e(812),__esModule:!0}},812:function(t,n,e){e(94),e(30),e(56),e(813),e(820),e(823),e(825),t.exports=e(5).Set},813:function(t,n,e){"use strict";var a=e(814),i=e(442);t.exports=e(816)("Set",function(t){return function(){return t(this,arguments.length>0?arguments[0]:void 0)}},{add:function(t){return a.def(i(this,"Set"),t=0===t?0:t,t)}},a)},814:function(t,n,e){"use strict";var a=e(7).f,i=e(53),r=e(440),s=e(50),o=e(441),f=e(315),c=e(52),p=e(92),d=e(815),u=e(10),l=e(86).fastKey,h=e(442),g=u?"_s":"size",v=function(t,n){var e,a=l(n);if("F"!==a)return t._i[a];for(e=t._f;e;e=e.n)if(e.k==n)return e};t.exports={getConstructor:function(t,n,e,c){var p=t(function(t,a){o(t,p,n,"_i"),t._t=n,t._i=i(null),t._f=void 0,t._l=void 0,t[g]=0,void 0!=a&&f(a,e,t[c],t)});return r(p.prototype,{clear:function(){for(var t=h(this,n),e=t._i,a=t._f;a;a=a.n)a.r=!0,a.p&&(a.p=a.p.n=void 0),delete e[a.i];t._f=t._l=void 0,t[g]=0},delete:function(t){var e=h(this,n),a=v(e,t);if(a){var i=a.n,r=a.p;delete e._i[a.i],a.r=!0,r&&(r.n=i),i&&(i.p=r),e._f==a&&(e._f=i),e._l==a&&(e._l=r),e[g]--}return!!a},forEach:function(t){h(this,n);for(var e,a=s(t,arguments.length>1?arguments[1]:void 0,3);e=e?e.n:this._f;)for(a(e.v,e.k,this);e&&e.r;)e=e.p},has:function(t){return!!v(h(this,n),t)}}),u&&a(p.prototype,"size",{get:function(){return h(this,n)[g]}}),p},def:function(t,n,e){var a,i,r=v(t,n);return r?r.v=e:(t._l=r={i:i=l(n,!0),k:n,v:e,p:a=t._l,n:void 0,r:!1},t._f||(t._f=r),a&&(a.n=r),t[g]++,"F"!==i&&(t._i[i]=r)),t},getEntry:v,setStrong:function(t,n,e){c(t,n,function(t,e){this._t=h(t,n),this._k=e,this._l=void 0},function(){for(var t=this,n=t._k,e=t._l;e&&e.r;)e=e.p;return t._t&&(t._l=e=e?e.n:t._t._f)?"keys"==n?p(0,e.k):"values"==n?p(0,e.v):p(0,[e.k,e.v]):(t._t=void 0,p(1))},e?"entries":"values",!e,!0),d(n)}}},815:function(t,n,e){"use strict";var a=e(6),i=e(5),r=e(7),s=e(10),o=e(2)("species");t.exports=function(t){var n="function"==typeof i[t]?i[t]:a[t];s&&n&&!n[o]&&r.f(n,o,{configurable:!0,get:function(){return this}})}},816:function(t,n,e){"use strict";var a=e(6),i=e(22),r=e(86),s=e(18),o=e(11),f=e(440),c=e(315),p=e(441),d=e(17),u=e(31),l=e(7).f,h=e(817)(0),g=e(10);t.exports=function(t,n,e,v,_,k){var x=a[t],m=x,b=_?"set":"add",y=m&&m.prototype,w={};return g&&"function"==typeof m&&(k||y.forEach&&!s(function(){(new m).entries().next()}))?(m=n(function(n,e){p(n,m,t,"_c"),n._c=new x,void 0!=e&&c(e,_,n[b],n)}),h("add,clear,delete,forEach,get,has,set,keys,values,entries,toJSON".split(","),function(t){var n="add"==t||"set"==t;t in y&&(!k||"clear"!=t)&&o(m.prototype,t,function(e,a){if(p(this,m,t),!n&&k&&!d(e))return"get"==t&&void 0;var i=this._c[t](0===e?0:e,a);return n?this:i})}),k||l(m.prototype,"size",{get:function(){return this._c.size}})):(m=v.getConstructor(n,t,_,b),f(m.prototype,e),r.NEED=!0),u(m,t),w[t]=m,i(i.G+i.W+i.F,w),k||v.setStrong(m,t,_),m}},817:function(t,n,e){var a=e(50),i=e(54),r=e(32),s=e(51),o=e(818);t.exports=function(t,n){var e=1==t,f=2==t,c=3==t,p=4==t,d=6==t,u=5==t||d,l=n||o;return function(n,o,h){for(var g,v,_=r(n),k=i(_),x=a(o,h,3),m=s(k.length),b=0,y=e?l(n,m):f?l(n,0):void 0;m>b;b++)if((u||b in k)&&(g=k[b],v=x(g,b,_),t))if(e)y[b]=v;else if(v)switch(t){case 3:return!0;case 5:return g;case 6:return b;case 2:y.push(g)}else if(p)return!1;return d?-1:c||p?p:y}}},818:function(t,n,e){var a=e(819);t.exports=function(t,n){return new(a(t))(n)}},819:function(t,n,e){var a=e(17),i=e(93),r=e(2)("species");t.exports=function(t){var n;return i(t)&&(n=t.constructor,"function"!=typeof n||n!==Array&&!i(n.prototype)||(n=void 0),a(n)&&null===(n=n[r])&&(n=void 0)),void 0===n?Array:n}},820:function(t,n,e){var a=e(22);a(a.P+a.R,"Set",{toJSON:e(821)("Set")})},821:function(t,n,e){var a=e(90),i=e(822);t.exports=function(t){return function(){if(a(this)!=t)throw TypeError(t+"#toJSON isn't generic");return i(this)}}},822:function(t,n,e){var a=e(315);t.exports=function(t,n){var e=[];return a(t,!1,e.push,e,n),e}},823:function(t,n,e){e(824)("Set")},824:function(t,n,e){"use strict";var a=e(22);t.exports=function(t){a(a.S,t,{of:function(){for(var t=arguments.length,n=new Array(t);t--;)n[t]=arguments[t];return new this(n)}})}},825:function(t,n,e){e(826)("Set")},826:function(t,n,e){"use strict";var a=e(22),i=e(87),r=e(50),s=e(315);t.exports=function(t){a(a.S,t,{from:function(t){var n,e,a,o,f=arguments[1];return i(this),n=void 0!==f,n&&i(f),void 0==t?new this:(e=[],n?(a=0,o=r(f,arguments[2],2),s(t,!1,function(t){e.push(o(t,a++))})):s(t,!1,e.push,e),new this(e))}})}},827:function(t,n,e){t.exports={default:e(828),__esModule:!0}},828:function(t,n,e){e(829),t.exports=e(5).Object.values},829:function(t,n,e){var a=e(22),i=e(830)(!1);a(a.S,"Object",{values:function(t){return i(t)}})},830:function(t,n,e){var a=e(23),i=e(13),r=e(24).f;t.exports=function(t){return function(n){for(var e,s=i(n),o=a(s),f=o.length,c=0,p=[];f>c;)r.call(s,e=o[c++])&&p.push(t?[e,s[e]]:s[e]);return p}}},831:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("div",{staticClass:"home-main"},[e("Row",{attrs:{gutter:10}},[e("Col",{attrs:{span:"24"}},[e("Card",[e("p",{attrs:{slot:"title"},slot:"title"},[e("Icon",{attrs:{type:"cube"}}),t._v("\n                月度绩效统计表 ( "+t._s(t.date)+" )\n                "),e("span",{staticClass:"cube"})],1),t._v(" "),e("Button",{staticClass:"button",staticStyle:{top:"10px",position:"absolute",left:"250px"},attrs:{type:t.type?"ghost":"primary",shape:"circle"},on:{click:t.routeType}},[t._v("按项目查看\n            ")]),t._v(" "),e("Button",{staticClass:"button",staticStyle:{top:"10px",position:"absolute",left:"350px"},attrs:{type:t.type?"primary":"ghost",shape:"circle"},on:{click:t.routeType}},[t._v("按员工查看\n            ")]),t._v(" "),e("Dropdown",{staticStyle:{top:"10px",position:"absolute",left:"600px"},on:{"on-click":t.excelNoteMark}},[e("Button",{attrs:{type:"success"}},[t._v("\n                    导出Excel\n                    "),e("Icon",{attrs:{type:"arrow-down-b"}})],1),t._v(" "),e("DropdownMenu",{attrs:{slot:"list"},slot:"list"},[e("DropdownItem",{attrs:{name:"mark"}},[t._v("考核分数表")]),t._v(" "),e("DropdownItem",{attrs:{name:"staff"}},[t._v("组织关系表")])],1)],1),t._v(" "),e("Button",{staticStyle:{float:"right","margin-left":"10px"},attrs:{size:"small"},on:{click:t.selectStaff}},[t._v("搜索")]),t._v(" "),e("Input",{staticStyle:{width:"120px",float:"right","margin-left":"20px"},attrs:{size:"small",placeholder:"搜索员工"},model:{value:t.staffSearch,callback:function(n){t.staffSearch=n},expression:"staffSearch"}}),t._v(" "),e("Select",{staticStyle:{width:"100px",float:"right"},attrs:{size:"small"},on:{"on-change":t.selectDepart},model:{value:t.depart,callback:function(n){t.depart=n},expression:"depart"}},[e("Option",{attrs:{value:"-1"}},[t._v("全部部门")]),t._v(" "),t._l(t.departStaffs,function(n){return e("Option",{key:n.id,attrs:{value:n.id}},[t._v(t._s(n.depart))])})],2),t._v(" "),e("div",{staticStyle:{"margin-bottom":"20px"}},[e("Button",{attrs:{type:-1===t.active?"info":"ghost",size:"small"},on:{click:function(n){t.rangeClick(-1)}}},[t._v("全部")]),t._v(" "),t._l(t.markRange,function(n,a){return e("Button",{staticStyle:{"margin-left":"10px"},attrs:{type:t.active===a?"info":"ghost",size:"small"},on:{click:function(n){t.rangeClick(a)}}},[t._v("\n                    "+t._s(n.appraise)+" ( "+t._s(n.number.length)+" )\n                ")])})],2),t._v(" "),t._l(t.departStaffs,function(n){return n.is_depart?t._e():e("div",{staticClass:"taskDiv"},[e("h4",{staticClass:"depart"},[t._v(t._s(n.depart))]),t._v(" "),t._l(n.staffs,function(n){return n.is_task?e("div",{staticClass:"departs"},[e("div",{staticClass:"staff"},[e("div",[e("span",[t._v(t._s(n.staff))]),t._v(" "),e("span",[t._v("岗位： "+t._s(n.position))]),t._v(" "),e("span",[t._v("绩效总分："+t._s(t.finMark[n.id]?t.finMark[n.id].toFixed(1):0))])])]),t._v(" "),e("div",{staticClass:"tasks"},t._l(t.markRange,function(a){return a.is_task[n.id]?e("div",{staticClass:"task"},[e("div",{staticClass:"appraise",class:a.active},[t._v(t._s(a.appraise))]),t._v(" "),e("div",{staticClass:"introduce"},t._l(a.tasks[n.id],function(a){return a?e("span",[t._l(n.marks,function(i){return t.attribute[a.task_id]&&i.task_id==a.task_id?e("Tooltip",{attrs:{content:"项目实际占比"+(a.is_mark?((i.mark+(t.isNotMark[n.id]?t.isNotMark[n.id]:0))/t.taskMark[n.id]*100).toFixed(1)+"%":"0"),placement:"top"}},[t._v("\n                                               "+t._s(t.taskNames[a.task_id])+"\n                                            "),a.is_mark?e("span",[t._v("( "+t._s(a.mark)+" )")]):t._e(),t._v(" "),a.is_mark?t._e():e("span",[t._v("( 未打分 )")])]):t._e()}),t._v(" "),t._l(n.marks,function(i){return t.attribute[a.task_id]||i.task_id!=a.task_id?t._e():e("Tooltip",{attrs:{content:"项目实际占比"+(a.is_mark?(i.mark/t.taskMark[n.id]*100).toFixed(1)+"%":"0"),placement:"top"}},[t._v("\n                                               "+t._s(t.taskNames[a.task_id])+"\n                                            "),a.is_mark?e("span",[t._v("( "+t._s(a.mark)+" )")]):t._e(),t._v(" "),a.is_mark?t._e():e("span",[t._v("( 未打分 )")])])})],2):t._e()}))]):t._e()})),t._v(" "),e("div",{staticClass:"clear"})]):t._e()})],2)})],2)],1)],1)],1)},i=[];a._withStripped=!0;var r={render:a,staticRenderFns:i};n.default=r}});