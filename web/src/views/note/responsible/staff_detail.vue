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
                    <span class="cube"></span>

                </p>
                <Button @click="routeType" style="top: 10px;position: absolute;left: 250px" class="button"
                        :type="type ? 'ghost' : 'primary'" shape="circle">按项目查看
                </Button>
                <Button @click="routeType" style="top: 10px;position: absolute;left: 350px" class="button"
                        :type="type ? 'primary' : 'ghost'" shape="circle">按员工查看
                </Button>

                <Select v-model="depart" @on-change="selectDepart" size="small" style="width:100px;float: right" >
                    <Option value="-1">全部部门</Option>
                    <Option v-for="item in departStaffs" :value="item.id" :key="item.id">{{ item.depart }}</Option>
                </Select>
                <div style="margin-bottom: 20px">
                    <Button :type="active === -1 ? 'info' : 'ghost'" size="small" @click="rangeClick(-1)">全部</Button>

                    <Button :type="active === index ? 'info' : 'ghost'" size="small"
                            v-for="(range , index) in markRange"
                            style="margin-left: 10px" @click="rangeClick(index)">
                        {{ range.appraise }} ( {{range.number.length}} )
                    </Button>
                </div>

                <div v-for="departs in departStaffs" class="taskDiv" v-if="!departs.is_depart">
                    <h4 class='depart'>{{ departs.depart }}</h4>

                    <div class="departs" v-for='staff in departs.staffs' v-show="staff.is_task">
                        <div class='staff'>
                            <span>{{ staff.staff}}</span>
                            <span>岗位： {{ staff.position}}</span>
                            <span>绩效总分：{{ Number(finMark[staff.id]).toFixed(0) }}</span>
                        </div>
                        <div class='tasks'>
                            <div class='task' v-for='range in markRange' v-if="range.is_task[staff.id]">
                                <div class='appraise' :class="range['active']">{{ range.appraise }}</div>
                                <div class='introduce'>
                                    <span v-for='task in range.tasks[staff.id]' v-if="task">
                                        {{ taskNames[task['task_id']] }}
                                        <span v-if="task['is_mark']">( {{ task['mark'] }} )</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='clear'></div>
                    </div>
                </div>
            </Card>
            </Col>
        </Row>
    </div>
</template>

<script>
    import $ from 'jquery'

    function hideStaff () {
        var tasks = document.getElementsByClassName('tasks');
        var length = tasks.length;
        if (length !== 0) {
            for (var i = 0; i < length; i++) {
                let count = $('.tasks').eq(i).find('.task').length
                // console.log(count + ' -- ' + i)
                if(count === 0){
                    $('.departs').eq(i).hide();
                }else {
                    $('.departs').eq(i).show();
                }
            }
            init()
        }
    }

    function init () {
        var tasks = document.getElementsByClassName('tasks');
        var staff = document.getElementsByClassName('staff');
        var length = tasks.length;
        if (length !== 0) {
            for (var i = 0; i < length; i++) {
                let height = tasks[i].offsetHeight;
                // staff[i].style.lineHeight = ((length - 3) * 10 + height) + 'px';
                staff[i].style.paddingTop = ((length - 3) * 15) + 'px';
                staff[i].style.height = ((length - 3) * 10 + height) + 'px';
            }
        }
    }

    export default {
        data () {
            return {
                formData: {
                    mark: [],
                    isMark: [],
                    staffId: [],
                    appraise: [],
                    introduce: [],
                },
                markRange: [{
                    'min': 96,
                    'max': 100,
                    'appraise': '优秀',
                    'introduce': 'A',
                    'tasks': [],
                    'active': 'activeSuccess',
                    'is_task': [],
                    'number': []
                },
                    {
                        'min': 90,
                        'max': 95,
                        'appraise': '优良',
                        'introduce': 'B',
                        'tasks': [],
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 80,
                        'max': 89,
                        'appraise': '合格',
                        'introduce': 'C',
                        'tasks': [],
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 60,
                        'max': 79,
                        'appraise': '不足',
                        'introduce': 'D',
                        'tasks': [],
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 1,
                        'max': 59,
                        'appraise': '不合格',
                        'introduce': 'E',
                        'tasks': [],
                        'active': 'activeError',
                        'is_task': [],
                        'number': []
                    },
                    {
                        'min': 0,
                        'max': 0,
                        'appraise': '未评价',
                        'introduce': '无',
                        'tasks': [],
                        'is_task': [],
                        'number': []
                    }
                ],
                loading: false,
                active: -1,
                date: '',
                tasks: [],
                taskNames: [],
                departStaffs: [],
                users: [],
                type: true,
                finMark: [],
                depart:''
            };
        },
        methods: {
            selectDepart() {
                Object.values(this.departStaffs).forEach(t=>{
                   if(this.depart == -1){
                       this.$set(t,'is_depart',false)
                   }else {
                       this.$set(t,'is_depart',true)
                       if(this.depart == t.id){
                           this.$set(t,'is_depart',false)
                       }
                   }
                })
            },
            rangeClick (index) {
                this.active = Number(index);
                this.tasks.forEach(t => {
                    console.log(t)
                    t.staffs.forEach(e => {
                        this.markRange.forEach((f, key) => {

                            if (f.min <= e.mark && e.mark <= f.max) {
                                if (index === -1 || key === index) {

                                    let tasks = f['tasks'][e.staff_id] || [];
                                    tasks.push(e);
                                    tasks = [...new Set(tasks)];
                                    this.$set(f['is_task'], e.staff_id, 1);
                                    this.$set(f['tasks'], e.staff_id, tasks);
                                } else {
                                    f['tasks'].splice(e.staff_id, 1);
                                    f['is_task'].splice(e.staff_id, 1);
                                    // this.$set(f['is_task'], e.staff_id, 0);
                                }
                            }
                        });
                    });
                });
                setTimeout(()=>{
                    hideStaff()
                },10)
            },
            goBack () {
                this.$router.push({
                    name: 'note-month',
                });
            },
            routeType () {
                this.$router.push({
                    name: 'note_task_detail',
                    query: ({
                        date: this.date
                    })
                });
            },

            getMarks () {
                this.JAjax.postJson('staff/fin/mark', {
                    date: this.date
                }, res => {
                    this.finMark = res.data || [];
                });
            },
            getDepartStaffs () {
                this.JAjax.postJson('depart/staffs', {
                    date: this.date
                }, res => {
                    this.departStaffs = res.data || [];
                    this.init();
                    this.getMarks();
                });
            },
            init () {
                this.date = this.$route.query.date;
                if (!this.date) {
                    this.$Message.error('未选择时间');
                } else {
                    this.JAjax.postJson('note/staff/date', {
                        date: this.date
                    }, res => {
                        this.tasks = res.data || [];
                        // this.departStaffs = res.staffs
                        this.tasks.forEach(t => {
                            t.staffs.forEach(e => {
                                this.markRange.forEach(f => {
                                    if (f.min <= e.mark && e.mark <= f.max) {
                                        let tasks = f['tasks'][e.staff_id] || [];
                                        tasks.push(e);
                                        this.$set(f['is_task'], e.staff_id, 1);
                                        this.$set(f['tasks'], e.staff_id, tasks);
                                    }
                                });
                            });
                        });
                        this.taskNames = res.tasks || [];
                        let t = Object.values(this.departStaffs);
                        t.forEach(e => {
                            Object.values(t).forEach(v => {
                                this.markRange.forEach((f) => {

                                    if (f.tasks.length > 0) {
                                        f.tasks.forEach((m, index) => {
                                            v.staffs.forEach(s => {
                                                if (s.id === index) {
                                                    s.is_task = true;
                                                    f.number.push(index);
                                                    f.number = [...new Set(f.number)];
                                                }
                                            });
                                        });
                                    }
                                });
                            });
                        });
                        // console.log(this.markRange);
                    });
                }
            }
        },
        updated () {
            init();
        },
        mounted () {
            this.getDepartStaffs();
        }
    };
</script>
