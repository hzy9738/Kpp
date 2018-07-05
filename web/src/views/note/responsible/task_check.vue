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
                    月度绩效审核 ( {{ date }} )
                </p>
                <div style="position: absolute;top: 14px;right:10px;width: 240px">
                    <span style="font-size: 16px;margin-right: 10px">审核</span>
                    <RadioGroup v-model="check">
                        <Radio label="2">通过</Radio>
                        <Radio label="3">拒绝</Radio>
                    </RadioGroup>
                    <Button type="info" @click="handSubmit">提交</Button>
                </div>
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
                        'min':69,'max':79,'appraise':'不足','introduce':'D','staffs':[]
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
                check:2
            };
        },
        methods: {
            handSubmit (){
                this.JAjax.postJson('note/check', {date:this.date,check:this.check}, res => {
                    this.$Message.success(res.message)
                    this.$router.push({
                        name: 'note-month',
                    });
                })
            },

            goBack () {
                this.$router.push({
                    name: 'note-month',
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
