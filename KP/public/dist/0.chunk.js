webpackJsonp([0],{436:function(t,n,a){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default={data:function(){return{formData:{mark:[],isMark:[],staffId:[],appraise:[],introduce:[],active:[],oldMark:[]},markRange:[{min:96,max:100,appraise:"优秀",introduce:"A",active:"activeSuccess"},{min:90,max:95.9,appraise:"优良",introduce:"B",active:""},{min:80,max:89.9,appraise:"合格",introduce:"C",active:""},{min:60,max:79.9,appraise:"不足",introduce:"D",active:""},{min:1,max:59.9,appraise:"不合格",introduce:"E",active:"activeError"}],loading:!1,active:[],staffs:[],tasks:[],noteTasks:[],finMark:[],isNotMark:[],taskId:"",task:{},date:"",attribute:0,warningModal:!1,isSubmit:!0}},methods:{alertMessage:function(){var t=this;this.isSubmit=!0,this.JAjax.postJson("note/is_depart/task",{date:this.date},function(n){n.data&&t.attribute&&(t.$Modal.warning({title:"提示",content:"尚有项目未录入，无法先录入部门中心项目"}),t.isSubmit=!1)})},getNoteTasks:function(t){this.date=t,this.getTasks()},getMarkRange:function(t,n){var a=this;this.markRange.forEach(function(i){n>=i.min&&n<=i.max&&(a.formData.appraise[t]=i.appraise,a.formData.introduce[t]=i.introduce,a.formData.active[t]=i.active)})},clickStaff:function(t){this.active=[],this.$set(this.active,t,!0)},handleSubmit:function(t){var n=this;if(""===this.date)return this.$Message.error("请先选择时间"),!1;if(0!==this.formData.staffId.length){var a=this.formData.staffId.length;if(.15*a>=.5){var i=[];this.formData.staffId.forEach(function(t){n.formData.isMark[t]&&n.formData.mark[t]<80&&i.push(t)}),i.length<.15*a?(this.warningModal=!0,console.log(i.length+"--"+a+"---    1")):(console.log(i.length+"--"+a+"---    2"),this.submitCallback())}else this.submitCallback()}else this.$Message.error("无法提交")},goBack:function(){this.$router.push({name:"note-month"})},warnBack:function(){this.warningModal=!1},warnGo:function(){this.submitCallback()},submitCallback:function(){var t=this;if(this.loading)return!1;this.loading=!0,this.formData.date=this.toMonth(this.date),this.formData.task_id=this.task.id,this.JAjax.postJson("note/month/task",this.formData,function(n){t.$Message.success(n.message),t.loading=!1,t.$router.push({name:"note-month"})}),this.loading=!1},getTasks:function(){var t=this;this.JAjax.postJson("task/all/list",{date:this.toMonth(this.date)},function(n){t.tasks=n.data||[],t.finMark=n.finMark||[],t.isNotMark=n.isNotMark||[]})},getTask:function(){var t=this;if(""===this.date)return void this.$Message.error("请先选择时间");this.formData.appraise=[],this.formData.oldMark=[],this.tasks.forEach(function(n){if(n.id===t.taskId){t.attribute=n.attribute,t.task=n,t.staffs=[],t.formData.staffId=[];var a=Date.parse(t.toMonth(t.date));n.staffs.forEach(function(n){null===n.leave_at?(t.formData.isMark[n.id]="0",t.formData.mark[n.id]=1,t.getMarkRange(n.id,0),t.staffs.push(n),t.formData.staffId.push(n.id),null!==n.pivot.mark&&t.$set(t.formData.oldMark,n.id,n.pivot.mark)):Date.parse(t.toMonth(n.leave_at))>=a&&(t.formData.isMark[n.id]="0",t.formData.mark[n.id]=1,t.getMarkRange(n.id,0),t.staffs.push(n),t.formData.staffId.push(n.id),null!==n.pivot.mark&&t.$set(t.formData.oldMark,n.id,n.pivot.mark))})}}),this.alertMessage()},getPreMonth:function(t){var n=t.split("-"),a=n[0],i=n[1],e=a,o=parseInt(i)-1;return 0==o&&(e=parseInt(e)-1,o=12),o<10&&(o="0"+o),e+"-"+o},init:function(){}},mounted:function(){this.init()}}},801:function(t,n,a){var i=a(802);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a(15)("5b941bd4",i,!1,{})},802:function(t,n,a){n=t.exports=a(14)(!1),n.push([t.i,"\n.margin-top-8 {\n  margin-top: 8px;\n}\n.margin-top-10 {\n  margin-top: 10px;\n}\n.margin-top-20 {\n  margin-top: 20px;\n}\n.margin-left-10 {\n  margin-left: 10px;\n}\n.margin-bottom-10 {\n  margin-bottom: 10px;\n}\n.margin-bottom-100 {\n  margin-bottom: 100px;\n}\n.margin-right-10 {\n  margin-right: 10px;\n}\n.padding-left-6 {\n  padding-left: 6px;\n}\n.padding-left-8 {\n  padding-left: 5px;\n}\n.padding-left-10 {\n  padding-left: 10px;\n}\n.padding-left-20 {\n  padding-left: 20px;\n}\n.height-100 {\n  height: 100%;\n}\n.height-120px {\n  height: 100px;\n}\n.height-200px {\n  height: 200px;\n}\n.height-492px {\n  height: 492px;\n}\n.height-460px {\n  height: 460px;\n}\n.line-gray {\n  height: 0;\n  border-bottom: 2px solid #dcdcdc;\n}\n.notwrap {\n  word-break: keep-all;\n  white-space: nowrap;\n  overflow: hidden;\n  text-overflow: ellipsis;\n}\n.padding-left-5 {\n  padding-left: 10px;\n}\n[v-cloak] {\n  display: none;\n}\n.dragging-tip-enter-active {\n  opacity: 1;\n  transition: opacity .3s;\n}\n.dragging-tip-enter,\n.dragging-tip-leave-to {\n  opacity: 0;\n  transition: opacity 0.3s;\n}\n.dragging-tip-con {\n  display: block;\n  text-align: center;\n  width: 100%;\n  height: 50px;\n}\n.dragging-tip-con span {\n  font-size: 18px;\n}\n.record-tip-con {\n  display: block;\n  width: 100%;\n  height: 292px;\n  overflow: auto;\n}\n.record-item {\n  box-sizing: content-box;\n  display: block;\n  overflow: hidden;\n  height: 24px;\n  line-height: 24px;\n  padding: 8px 10px;\n  border-bottom: 1px dashed gainsboro;\n}\n.record-tip-con span {\n  font-size: 14px;\n}\n.edittable-test-con {\n  height: 160px;\n}\n.edittable-table-height-con {\n  height: 190px;\n}\n.edittable-con-1 {\n  box-sizing: content-box;\n  padding: 15px 0 0;\n  height: 196px;\n}\n.edittable-table-get-currentdata-con {\n  height: 190px !important;\n}\n.exportable-table-download-con1 {\n  padding: 16px 0 16px 20px;\n  border-bottom: 1px dashed #c3c3c3;\n  margin-bottom: 16px;\n}\n.exportable-table-download-con2 {\n  padding-left: 20px;\n}\n.show-image {\n  padding: 20px 0px;\n}\n.show-image img {\n  display: block;\n  width: 100%;\n  height: auto;\n}\n.searchable-table-con1 {\n  height: 230px !important;\n}\n.ivu-form-item-error-tip {\n  width: 200px;\n}\n.clear {\n  clear: both;\n}\n.title {\n  text-align: center;\n  font-weight: bold;\n  height: 50px;\n  line-height: 50px;\n  padding-left: 30px;\n  margin: -10px 0 10px 0;\n  background: #e6e6e6;\n}\n.depart {\n  text-align: center;\n  font-weight: bold;\n  height: 30;\n  line-height: 30px;\n  padding-left: 30px;\n  margin: -10px 0 10px 0;\n  background: #f4f4f4;\n}\n.departs {\n  margin-top: 10px;\n  clear: both;\n}\n.departs .staff {\n  width: 15%;\n  float: left;\n  position: relative;\n  text-align: center;\n  background: #d7d7d7;\n  margin-right: 1%;\n}\n.departs .staff div {\n  position: absolute;\n  width: 100%;\n  text-align: center;\n  -webkit-transform: translateY(-50%);\n          transform: translateY(-50%);\n  top: 50%;\n}\n.departs .staff span {\n  display: block;\n  height: 20px;\n}\n.departs .tasks {\n  min-height: 60px;\n  width: 84%;\n  float: left;\n}\n.departs .tasks .task:after {\n  content: '';\n  display: block;\n  clear: both;\n}\n.departs .tasks .task {\n  width: 100%;\n  line-height: 50px;\n  margin-bottom: 10px;\n}\n.departs .tasks .task:first-child {\n  margin-top: 20px;\n}\n.departs .tasks .task .appraise {\n  width: 6%;\n  float: left;\n  text-align: center;\n  background: #d7d7d7;\n}\n.departs .tasks .task .introduce {\n  border: 1px #999 solid;\n  margin-top: -1px;\n  width: 94%;\n  float: left;\n  padding-left: 10px;\n}\n.departs .tasks .task .introduce span {\n  display: inline-block;\n  height: 30px;\n  line-height: 30px;\n  background: #f4f4f4;\n  padding-left: 10px;\n  margin-right: 10px;\n}\n.details {\n  clear: both;\n  border: 1px #666666 solid;\n  border-top: none;\n  margin-top: -10px;\n  padding: 5px 10px;\n}\n.details > div {\n  margin-bottom: 10px;\n  line-height: 60px;\n  border: 1px #666666 solid;\n}\n.details > div .markRange {\n  display: inline-block;\n  width: 100px;\n  text-align: center;\n  background: #d7d7d7;\n  position: relative;\n  top: -1px;\n  left: -1px;\n}\n.details > div .span {\n  height: 35px;\n  line-height: 35px;\n  padding: 0 10px;\n  background: #f2f2f2;\n  margin: auto auto;\n  display: inline-block;\n  margin-left: 10px;\n}\nform .staff {\n  text-align: center;\n  line-height: 40px;\n  background: #f4f4f4;\n}\n.active {\n  background: #80cbfa;\n}\n.activeSuccess {\n  color: green;\n}\n.activeError {\n  color: red;\n}\n.taskDiv {\n  margin-bottom: 20px;\n}\n",""])},803:function(t,n,a){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var i=function(){var t=this,n=t.$createElement,a=t._self._c||n;return a("div",{staticClass:"home-main"},[a("Row",{attrs:{gutter:10}},[a("Col",{attrs:{span:"24"}},[a("Card",[a("p",{attrs:{slot:"title"},slot:"title"},[a("Icon",{attrs:{type:"cube"}}),t._v("\n                按项目录入绩效\n            ")],1),t._v(" "),a("DatePicker",{staticStyle:{position:"absolute",top:"10px",left:"150px",width:"150px"},attrs:{type:"month",placeholder:"选择时间"},on:{"on-change":t.getNoteTasks},model:{value:t.date,callback:function(n){t.date=n},expression:"date"}}),t._v(" "),a("Select",{staticStyle:{position:"absolute",top:"10px",left:"340px",width:"150px"},attrs:{placeholder:"选择项目"},on:{"on-change":t.getTask},model:{value:t.taskId,callback:function(n){t.taskId=n},expression:"taskId"}},[0===t.tasks.length?a("Option",{key:"0",attrs:{value:"0"}},[t._v("无项目待提交")]):t._e(),t._v(" "),t._l(t.tasks,function(n){return 0!==t.tasks.length?a("Option",{key:n.id,attrs:{value:n.id}},[t._v(t._s(n.task))]):t._e()})],2),t._v(" "),a("Row",[0===t.staffs.length?a("Row",[a("div",{staticStyle:{"margin-bottom":"40px",color:"#999999"}},[t._v("请先确定时间，并选择项目")]),t._v(" "),a("div",[a("Button",{staticStyle:{width:"100px","margin-right":"50px"},on:{click:t.goBack}},[t._v("返回")])],1)]):t._e(),t._v(" "),0!==t.staffs.length?a("Form",{ref:"formData",attrs:{model:t.formData}},[a("Row",{staticClass:"title",attrs:{gutter:16}},[t._v(t._s(t.task.task)+" 项目成员绩效")]),t._v(" "),t._l(t.staffs,function(n,i){return a("Row",{staticClass:"staff",class:t.active[i]?"active":""},[a("div",{on:{click:function(n){t.clickStaff(i)}}},[a("Col",{attrs:{span:"6"}},[t._v(t._s(n.staff)+"（"+t._s(n.position)+"）")]),t._v(" "),a("Col",{attrs:{span:"6"}},[a("RadioGroup",{model:{value:t.formData.isMark[n.id],callback:function(a){t.$set(t.formData.isMark,n.id,a)},expression:"formData.isMark[staff.id]"}},[a("Radio",{attrs:{label:"0"}},[t._v("本月不考核")]),t._v(" "),a("Radio",{attrs:{label:"1"}},[t._v("考核得分")])],1)],1),t._v(" "),a("Col",{attrs:{span:"6"}},[a("InputNumber",{staticStyle:{width:"100px"},attrs:{max:100,min:1,disabled:"1"!==t.formData.isMark[n.id]},on:{"on-change":function(a){t.getMarkRange(n.id,t.formData.mark[n.id])}},model:{value:t.formData.mark[n.id],callback:function(a){t.$set(t.formData.mark,n.id,a)},expression:"formData.mark[staff.id]"}}),t._v(" "),a("div",{staticStyle:{display:"inline-block",width:"100px"}},["1"===t.formData.isMark[n.id]?a("span",{class:t.formData.active[n.id]},[t._v(t._s(t.formData.appraise[n.id]))]):t._e()])],1),t._v(" "),a("Col",{attrs:{span:"6"}},[t.attribute?t._e():a("span",[t._v("  ( 绩效权重"+t._s(null!==n.pivot.mark?(n.pivot.mark/t.finMark[n.id]*100).toFixed(1)+"%":"0")+" )")]),t._v(" "),t.attribute?a("span",[t._v("  ( 绩效权重"+t._s(null!==n.pivot.mark?((n.pivot.mark+(t.isNotMark[n.id]?t.isNotMark[n.id]:0))/t.finMark[n.id]*100).toFixed(1)+"%":"0")+" )")]):t._e()])],1)])}),t._v(" "),a("Col",{staticStyle:{"margin-top":"30px"},attrs:{span:"6",gutter:16}},[a("Button",{staticStyle:{width:"100px","margin-right":"50px"},on:{click:t.goBack}},[t._v("返回")]),t._v(" "),t.isSubmit?a("Button",{staticStyle:{width:"100px"},attrs:{loading:t.loading,type:"primary"},on:{click:function(n){t.handleSubmit("formData")}}},[t.loading?a("span",[t._v("Loading...")]):a("span",[t._v("提交")])]):t._e()],1)],2):t._e()],1)],1)],1)],1),t._v(" "),a("Modal",{attrs:{width:"360"},model:{value:t.warningModal,callback:function(n){t.warningModal=n},expression:"warningModal"}},[a("p",{staticStyle:{color:"#f60","text-align":"center"},attrs:{slot:"header"},slot:"header"},[a("Icon",{attrs:{type:"information-circled"}}),t._v(" "),a("span",[t._v("提示")])],1),t._v(" "),a("div",{staticStyle:{"text-align":"center"}},[a("p",{staticStyle:{"text-align":"left"}},[t._v("请注意:")]),t._v(" "),a("p",[t._v("各项目/中心每月考评结果为D级或E级的员工占考核总数的15%。")])]),t._v(" "),a("div",{attrs:{slot:"footer"},slot:"footer"},[a("Button",{attrs:{type:"success"},on:{click:t.warnBack}},[t._v("返回修改")]),t._v(" "),a("Button",{on:{click:t.warnGo}},[t._v("确定，继续提交")])],1)])],1)},e=[];i._withStripped=!0;var o={render:i,staticRenderFns:e};n.default=o},94:function(t,n,a){"use strict";function i(t){l||a(801)}Object.defineProperty(n,"__esModule",{value:!0});var e=a(436),o=a.n(e);for(var s in e)"default"!==s&&function(t){a.d(n,t,function(){return e[t]})}(s);var r=a(803),d=a.n(r),l=!1,p=a(1),c=i,f=p(o.a,d.a,!1,c,null,null);f.options.__file="src\\views\\note\\month\\task.vue",n.default=f.exports}});