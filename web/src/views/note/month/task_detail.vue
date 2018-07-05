<style lang="less">
    @import "../../../styles/common.less";
    @import './components/table.less';
</style>
<template>
    <div class="home-main">
        <Row :gutter="10">
            <Col span="24">
            <Card>
                <p slot="title">
                    <Icon type="cube"></Icon>
                    月度绩效统计表 ( {{ date }} )
                </p>
                <Select v-model="task" @on-change="selectTask" placeholder="搜索项目名称" size="small" style="width:160px;float: right;margin-top: -50px" >
                    <Option value="-1">全部项目</Option>
                    <Option :value="item.task_id" v-for="item in tasks">{{ taskNames[item.task_id] }}</Option>
                </Select>

                <Button @click="routeType" style="top: 10px;position: absolute;left: 250px" class="button" :type="type ? 'primary' : 'ghost'" shape="circle">按项目查看</Button>
                <Button @click="routeType" style="top: 10px;position: absolute;left: 350px" class="button" :type="type ? 'ghost' : 'primary'" shape="circle">按员工查看</Button>

                <!--<Button  style="top: 10px;position: absolute;left: 600px" class="button" type="success" shape="circle">导出Excel</Button>-->
                <Dropdown  style="top: 10px;position: absolute;left: 600px" @on-click="excelNoteMark">
                    <Button type="success">
                        导出Excel
                        <Icon type="arrow-down-b"></Icon>
                    </Button>
                    <DropdownMenu slot="list" >
                        <DropdownItem name="mark">考核分数表</DropdownItem>
                        <DropdownItem name="staff">组织关系表</DropdownItem>
                    </DropdownMenu>
                </Dropdown>

                <div v-for="task in tasks" class="taskDiv"  v-if="!task.is_task">
                    <h4 class="title" >
                        <span>{{ taskNames[task.task_id] }}</span>
                        <span>( {{ users[task.tasks.responsible]}} )</span>
                    </h4>
                    <div class="details">
                        <div v-for="range in markRange" class="detailsRange" >
                                <span class="markRange" :class="range['active']">{{ range.appraise }}</span>
                                <span  class="span" v-for="item in range.staffs[task.task_id]" v-if="item && staffs[item['staff_id']]">
                                    <span >{{ staffs[item['staff_id']] }}</span>
                                    <span v-if="item['is_mark']"> ( {{ item['mark'] }} )</span>
                                </span>
                        </div>
                    </div>
                </div>
            </Card>
            </Col>
        </Row>
    </div>
</template>

<script>
    import $ from 'jquery'

    function init () {
        var num = $('.detailsRange').length
        for(let i=0;i<num;i++){
           let number =  $('.detailsRange').eq(i).find('.span').length
            if(!number){
                $('.detailsRange').eq(i).hide()
            }
        }
    }


    export default {
        data () {
            return {
                formData: {
                    mark: [],
                    isMark: [],
                    staffId:[],
                    appraise:[],
                    introduce:[],
                },
                markRange: [
                    {
                        'min':96,'max':100,'appraise':'优秀','introduce':'A','staffs':[],'active':'activeSuccess'
                    },
                    {
                        'min':90,'max':95.9,'appraise':'优良','introduce':'B','staffs':[]
                    },
                    {
                        'min':80,'max':89.9,'appraise':'合格','introduce':'C','staffs':[]
                    },
                    {
                        'min':60,'max':79.9,'appraise':'不足','introduce':'D','staffs':[],'active':'activeError'
                    },
                    {
                        'min':1,'max':59.9,'appraise':'不合格','introduce':'E','staffs':[],'active':'activeError'
                    },
                    {
                        'min':0,'max':0,'appraise':'未评价','introduce':'无','staffs':[]
                    }
                ],
                loading: false,
                date: '',
                tasks:[],
                tasksCopy:[],
                taskNames:[],
                staffs:[],
                users:[],
                type:true,
                task:''
            };
        },
        methods: {
            excelNoteMark(name){
                let date = this.date
                if(name === 'mark'){
                    window.open('/api/note/excel?date='+date)
                }else  if(name === 'staff'){
                    window.open('/api/note/staff_excel?date='+date)
                }
            },
            selectTask(id){
               this.tasks.forEach((t , index)=>{
                  if(id === '-1'){
                      this.$set(t,'is_task',false)
                  }else if(t.task_id === id){
                       this.$set(t,'is_task',false)
                   }else {
                       this.$set(t,'is_task',true)
                   }
               })
            },
            goBack () {
                this.$router.push({
                    name: 'note-month',
                });
            },
            routeType() {
                this.$router.push({
                    name: 'note_staff_detail',
                    query:({
                        date:this.date
                    })
                });
            },
            init () {
                this.date = this.$route.query.date
                if(!this.date){
                    this.$Message.error('未选择时间')
                }else {
                    this.JAjax.postJson('note/task/date', {date:this.date}, res => {
                        this.tasks = res.data || [];
                        this.tasksCopy = res.data || [];
                        this.tasks.forEach(t=>{
                             t.staffs.forEach(e=>{
                                 this.markRange.forEach(f=>{
                                     if( f.min <= e.mark && e.mark <= f.max){
                                         let staffs = f['staffs'][t.task_id] || []
                                         staffs.push(e)
                                        this.$set(f['staffs'],t.task_id,staffs)
                                     }
                                 })
                             })
                        })
                        this.staffs = res.staffs || [];
                        this.taskNames = res.tasks || [];
                        this.users = res.users || [];
// console.log(this.markRange)
                    });
                }
            }
        },
        updated (){
           init()
        },
        mounted () {

            this.init();
        }
    };
</script>
