<template>
    <div class="container content">
        <div class="row">
            <div class="col-sm-12 col-md-8 offset-md-2">
                <div class="heading row">
                    <div class="col-8">
                        <h1>TODO一覧</h1>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-end" v-if="tasks.length">
                        <RouterLink v-bind:to="{ name: 'task.new' }">
                            <button class="btn btn-outline-secondary">追加</button>
                        </RouterLink>
                    </div>
                </div>
                <div class="row" v-if="tasks.length">
                    <div class="col-12 text-right">
                        <label for="display-count">表示件数</label>
                        <select name="per-page" id="display-count" v-model="perPage" v-bind:checked="perPage"
                            v-on:change="changePerPage">
                            <option value="1">1</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center no-data" v-if="!tasks.length">
                    <div class="text-center">
                        <p class="text-black-50">まだタスクはありません</p>
                        <p>
                            <RouterLink v-bind:to="{ name: 'task.new' }">
                                <button class="btn btn-outline-secondary">追加</button>
                            </RouterLink>
                        </p>
                    </div>
                </div>
                <table class="table table-hover" v-if="tasks.length">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th class="responsive-by-char-count">
                                概要<br />
                                <span style="font-size: x-small">(登録日)</span>
                            </th>
                            <th>進捗</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in tasks" :key="task.id">
                            <td scope="row">{{ task.id }}</td>
                            <td class="responsive-by-char-count">{{ task.description }}<br />
                                <div class="text-right"><span style="font-size: x-small">{{
                                        getFormattedTime(task.created_at)
                                }}</span></div>
                            </td>
                            <td>
                                <span class="badge badge-light" v-if="task.done === 0">未完了</span>
                                <span class="badge badge-success" v-else>完了</span>
                            </td>
                            <td>
                                <router-link v-bind:to="{ name: 'task.edit', params: { taskId: task.id } }">
                                    <button class="btn btn-outline-secondary">
                                        <font-awesome-icon icon="fa-solid fa-pen" />
                                    </button>
                                </router-link>
                                <button class="btn btn-outline-secondary" v-on:click="deleteTask(task.id)">
                                    <font-awesome-icon icon="fa-solid fa-trash" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="getPageCount > 1">
                    <VuejsPaginate v-model="currentPage" :pageCount="getPageCount" :prevText="'<'" :nextText="'>'"
                        :clickHandler="paginateClickCallback" :containerClass="'pagination'" :first-last-button="true"
                        :first-button-text="'<<'" :last-button-text="'>>'" :pageClass="'page-item'">
                    </VuejsPaginate>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueJsPaginate from "vuejs-paginate";
import { format } from "date-fns";
import { ja } from "date-fns/locale";

const FIRST_PAGE_NUMBER = 1;
const DEFAULT_PER_PAGE = "10";

export default {
    components: {
        'VuejsPaginate': VueJsPaginate
    },
    data: function () {
        return {
            tasks: [],
            currentPage: this.currentPage = this.$route.query.page || FIRST_PAGE_NUMBER,
            perPage: this.perPage = this.$route.query.perPage || DEFAULT_PER_PAGE,
            totalCount: 0,
        };
    },
    methods: {
        getTasks() {
            axios.get(`/api/tasks`, { params: { perPage: this.perPage, page: this.currentPage } }).then((res) => {
                const result = res.data;
                this.tasks = result.data;
                this.currentPage = result.current_page;
                this.perPage = result.per_page;
                this.totalCount = result.total;
            }).catch((error) => {
                console.log(error)
            });
        },
        deleteTask(id) {
            axios.delete("/api/tasks/" + id).then((res) => {
                this.getTasks();
            });
        },
        paginateClickCallback: function (pageNum) {
            this.currentPage = pageNum;
            this.$router.push({ name: 'tasks', query: { perPage: this.perPage, page: this.currentPage, } })
            this.$scrollTo('#app', 1000, { offset: -60 });
        },
        changePerPage(e) {
            const changedPerPage = e.target.value;
            if (["1", "10", "20"].includes(changedPerPage)) {
                this.perPage = changedPerPage;
            } else {
                this.perPage = DEFAULT_PER_PAGE;
            }
            this.currentPage = 1;
            this.$router.push({ name: 'tasks', query: { perPage: this.perPage, page: this.currentPage, } })

        },
        getFormattedTime(time) {
            if (time) {
                return format(new Date(time), "M / dd (E)", { locale: ja });
            }
        },
    },
    beforeRouteUpdate(to, from, next) {
        // UGLY: next()を実行しないとqueryの値が更新されない
        // [【Nuxt.js/Vue.js】<nuxt-link>や$router.pushで同じパスに遷移すると画面が更新されない](https://zenn.dev/kokota/articles/352ecf9ada3a48)
        next();
        this.getTasks(to.query.perPage, to.query.page);
    },
    computed: {
        getPageCount: function () {
            return Math.ceil(this.totalCount / this.perPage);
        }
    },
    mounted() {
        this.getTasks(FIRST_PAGE_NUMBER);
    },
};
</script>

<style>
.active {
    background-color: blue;
    color: white;
}

.inactive {
    color: #337abc;
}

.pagination {
    display: flex;
    list-style-type: none;
}

.pagination li {
    border: 1px solid #ddd;
    padding: 6px 12px;
    text-align: center;
    cursor: pointer;
}

.pagination li.disabled,
.pagination li.disabled a,
.page-item.disabled,
.page-item.disabled a {
    color: #616A71;
    opacity: .5;
    cursor: not-allowed;
}

.pagination li+li {
    border-left: none;
}

.responsive-by-char-count {
    min-width: 8rem;
}

.no-data {
    height: calc(100vh - 4rem - 3rem)
}
</style>
