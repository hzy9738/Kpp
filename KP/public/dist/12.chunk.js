webpackJsonp([12],{233:function(n,t,e){"use strict";function i(n){p||e(837)}Object.defineProperty(t,"__esModule",{value:!0});var o=e(445),a=e.n(o);for(var r in o)"default"!==r&&function(n){e.d(t,n,function(){return o[n]})}(r);var s=e(839),d=e.n(s),p=!1,c=e(1),l=i,h=c(a.a,d.a,!1,l,null,null);h.options.__file="src\\views\\system\\role\\permission.vue",t.default=h.exports},445:function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={data:function(){return{formData:{route:[],child_route:[],use_route:[]},role:"",pages:[],childPages:[],uses:[],permissions:[],loading:!1}},methods:{handleSubmit:function(n){var t=this;if(this.loading)return!1;this.loading=!0;var e=[],i=[],o=[],a=this.$refs.tree.getCheckedNodes();console.log(a),a.forEach(function(n){1===n.ident?e.push(n.id):2===n.ident?i.push(n.id):3===n.ident&&o.push(n.id)}),this.formData.route=e,this.formData.child_route=i,this.formData.use_route=o,this.JAjax.postJson("role/permissions/add/"+this.$route.query.id,this.formData,function(n){t.$Message.success(n.message),t.init(),t.initAccess(),setTimeout(function(){t.loading=!1},500)})},goBack:function(){this.$router.push({name:"role"})},getPermssions:function(){var n=this;this.JAjax.postJson("role/permissions",{},function(t){n.permissions=t.data,n.permissions.forEach(function(t){console.log(n.pages),-1!==n.pages.indexOf(t.id)&&n.$set(t,"checked",!0),t.children.forEach(function(t){-1!==n.childPages.indexOf(t.id)&&n.$set(t,"checked",!0),t.children.forEach(function(t){-1!==n.uses.indexOf(t.id)&&n.$set(t,"checked",!0)})})})})},getTheRolePermission:function(){var n=this;this.JAjax.postJson("role/permissions/"+this.$route.query.id,{},function(t){n.role=t.data.role,n.pages=t.data.pages.map(function(n){return n.id}),n.childPages=t.data.child_pages.map(function(n){return n.id}),n.uses=t.data.uses.map(function(n){return n.id}),n.getPermssions()})},init:function(){this.getTheRolePermission()},initAccess:function(){var n=this;this.JAjax.postJson("role/permissions",{},function(t){n.departs=t.data||{},Cookies.set("access",t.user.permissions)})}},mounted:function(){this.init()}}},837:function(n,t,e){var i=e(838);"string"==typeof i&&(i=[[n.i,i,""]]),i.locals&&(n.exports=i.locals);e(15)("22c467fa",i,!1,{})},838:function(n,t,e){t=n.exports=e(14)(!1),t.push([n.i,"\n.user-infor {\n  height: 135px;\n}\n.avator-img {\n  display: block;\n  width: 80%;\n  max-width: 100px;\n  height: auto;\n}\n.card-user-infor-name {\n  font-size: 2em;\n  color: #2d8cf0;\n}\n.card-title {\n  color: #abafbd;\n}\n.made-child-con-middle {\n  height: 100%;\n}\n.to-do-list-con {\n  height: 145px;\n  overflow: auto;\n}\n.to-do-item {\n  padding: 2px;\n}\n.infor-card-con {\n  height: 100px;\n}\n.infor-card-icon-con {\n  height: 100%;\n  color: white;\n  border-radius: 3px 0 0 3px;\n}\n.map-con {\n  height: 305px;\n}\n.map-incon {\n  height: 100%;\n}\n.data-source-row {\n  height: 200px;\n}\n.line-chart-con {\n  height: 150px;\n}\n.ivu-collapse {\n  background-color: #f7f7f7;\n  border-radius: 3px;\n  border: none;\n  margin-bottom: 10px;\n}\n.ivu-collapse > .ivu-collapse-item {\n  border: none;\n}\n.depart-header {\n  background-color: #f7f7f7;\n  margin-bottom: 10px;\n  height: 40px;\n  line-height: 40px;\n  padding-left: 30px;\n  color: #333333;\n  font-size: 16px;\n  position: relative;\n}\n.depart-header .button {\n  position: absolute;\n  right: 10px;\n  top: 5px;\n}\n.right {\n  float: right;\n  margin: 5px 10px 0 0 ;\n}\n.small_right {\n  float: right;\n  margin: 8px 10px 0 0 ;\n}\n.margin-top-8 {\n  margin-top: 8px;\n}\n.margin-top-10 {\n  margin-top: 10px;\n}\n.margin-top-20 {\n  margin-top: 20px;\n}\n.margin-left-10 {\n  margin-left: 10px;\n}\n.margin-bottom-10 {\n  margin-bottom: 10px;\n}\n.margin-bottom-100 {\n  margin-bottom: 100px;\n}\n.margin-right-10 {\n  margin-right: 10px;\n}\n.padding-left-6 {\n  padding-left: 6px;\n}\n.padding-left-8 {\n  padding-left: 5px;\n}\n.padding-left-10 {\n  padding-left: 10px;\n}\n.padding-left-20 {\n  padding-left: 20px;\n}\n.height-100 {\n  height: 100%;\n}\n.height-120px {\n  height: 100px;\n}\n.height-200px {\n  height: 200px;\n}\n.height-492px {\n  height: 492px;\n}\n.height-460px {\n  height: 460px;\n}\n.line-gray {\n  height: 0;\n  border-bottom: 2px solid #dcdcdc;\n}\n.notwrap {\n  word-break: keep-all;\n  white-space: nowrap;\n  overflow: hidden;\n  text-overflow: ellipsis;\n}\n.padding-left-5 {\n  padding-left: 10px;\n}\n[v-cloak] {\n  display: none;\n}\n",""])},839:function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){var n=this,t=n.$createElement,e=n._self._c||t;return e("div",{staticClass:"home-main"},[e("Row",{attrs:{gutter:10}},[e("Col",{attrs:{span:"24"}},[e("Card",[e("p",{attrs:{slot:"title"},slot:"title"},[e("Icon",{attrs:{type:"cube"}}),n._v("\n                权限分配 (  "+n._s(n.role)+"  )\n            ")],1),n._v(" "),e("Row",[e("Form",{ref:"formData",staticStyle:{"padding-left":"10%"},attrs:{model:n.formData,"label-width":100}},[e("Tree",{ref:"tree",staticStyle:{"margin-bottom":"20px"},attrs:{data:n.permissions,"show-checkbox":""}}),n._v(" "),e("Button",{staticStyle:{width:"100px","margin-right":"50px"},on:{click:n.goBack}},[n._v("取消")]),n._v(" "),e("Button",{staticStyle:{width:"100px"},attrs:{loading:n.loading,type:"primary"},on:{click:function(t){n.handleSubmit("formData")}}},[n.loading?e("span",[n._v("Loading...")]):e("span",[n._v("保存")])])],1)],1)],1)],1)],1)],1)},o=[];i._withStripped=!0;var a={render:i,staticRenderFns:o};t.default=a}});