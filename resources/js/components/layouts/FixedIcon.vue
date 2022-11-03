<template>
    <div v-if="!(hiddenWechat || !wechatNum)" class="fixed-icon" @click="showDialog">
        <van-image width="40"
                   height="40"
                   src="https://pic.imgdb.cn/item/6297261a0947543129b15dd0.png"
                   round/>
    </div>
    <van-dialog v-model:show="show"
                theme="round-button"
                confirmButtonText="去微信添加客服"
                @confirm="confirmDialog"
                title="微信号已复制">
        <div class="wechat-num" @click="copyWechat">
            {{ wechatNum }}
        </div>
        <div class="wechat-info">
            添加微信号联系客服
        </div>
    </van-dialog>
</template>
<script>
import lodash from 'lodash'
import {ref} from "vue";
import copy from 'copy-to-clipboard';

export default {
    setup() {
        const show = ref(false);
        const hiddenWechat = lodash.get(window._setting_, 'hidden_wechat_icon')
        const wechatNum = lodash.get(window._setting_, 'customer_wechat')
        const copyWechat = () => {
            copy(wechatNum, {
                debug: true,
            });
        }
        const showDialog = () => {
            show.value = true;
            copyWechat();
        }
        const confirmDialog = () => {
            var chatUrl = "weixin://";
            if (/ipad|iphone|mac/i.test(navigator.userAgent)) {
                var ifr = document.createElement("iframe");
                ifr.src = chatUrl;
                ifr.style.display = "none";
                document.body.appendChild(ifr);
                setTimeout(() => {
                    ifr.parentNode.removeChild(ifr);
                }, 8000)
            } else {
                window.location.href = chatUrl;
            }

            show.value = false;
        }

        return {
            show,
            wechatNum,
            hiddenWechat,
            showDialog,
            confirmDialog,
            copyWechat,
        }
    }
}
</script>
<style scoped lang="less">

.fixed-icon {
    position: fixed;
    bottom: 15vh;
    right: 3vw;
    z-index: 100;


}

.wechat-num {
    box-sizing: border-box;
    width: 232px;
    height: 44px;
    line-height: 24px;
    font-size: 16px;
    background-color: #f5f5f6;
    text-align: center;

    padding: 10px 8px;
    border: 1px solid #e0e0e0;
    border-radius: 2px;
    color: #222;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 20px auto 0;
}

.wechat-info {
    font-size: 14px;
    color: #9c9c9c;
    font-weight: 400;
    margin-top: 12px;
    text-align: center;
    padding: 0 10px;
    margin-bottom: 20px;
}
</style>
