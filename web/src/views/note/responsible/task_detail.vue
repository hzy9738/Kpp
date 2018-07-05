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
                <Button @click="routeType" style="top: 10px;position: absolute;left: 250px" class="button" :type="type ? 'primary' : 'ghost'" shape="circle">按项目查看</Button>
                <Button @click="routeType" style="top: 10px;position: absolute;left: 350px" class="button" :type="type ? 'ghost' : 'primary'" shape="circle">按员工查看</Button>
                <div v-for="task in tasks" class="taskDiv" >
                    <h4 class="title" >
                        <span>{{ taskNames[task.task_id] }}</span>
                        <span>( {{ users[task.tasks.responsible]}} )</span>
                    </h4>
                    <div class="details">
                        <div v-for="range in markRange" v-if="range.staffs.length > 0">
                                <span class="markRange" :class="range['active']">{{ range.appraise }}</span>
                                <span class="span" v-for="item in range.staffs[task.task_id]" v-if="item">
                                    <span>{{ staffs[item['staff_id']] }}</span>
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
                        'min':90,'max':95,'appraise':'优良','introduce':'B','staffs':[]
                    },
                    {
                        'min':80,'max':89,'appraise':'合格','introduce':'C','staffs':[]
                    },
                    {
                        'min':60,'max':79,'appraise':'不足','introduce':'D','staffs':[]
                    },
                    {
                        'min':1,'max':59,'appraise':'不合格','introduce':'E','staffs':[],'active':'activeError'
                    },
                    {
                        'min':0,'max':0,'appraise':'未评价','introduce':'无','staffs':[]
                    }
                ],
                loading: false,
                date: '',
                tasks:[],
                taskNames:[],
                staffs:[],
                users:[],
                type:true
            };
        },
        methods: {

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
        mounted () {

            this.init();
        }
    };
</script>
