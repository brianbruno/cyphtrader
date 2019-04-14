<template>
    <div>
        <vue-topprogress ref="topProgress"></vue-topprogress>

        <div class="col-lg-3">
            <div class="card card-default bg-success">
                <div class="card-body text-white">
                    <div class="row">
                        <div class="col-md-8 text-left">
                            <h3>TRX/BTC</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-danger">Closed</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <span class="font-weight-lighter">124 BTC</span><br>
                            <span class="font-weight-light">+2,5%</span><br>
                            <span class="font-weight-normal">+0.02127689</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import { vueTopprogress } from 'vue-top-progress'

    export default {
        mounted () {
            this.$refs.topProgress.start()

            // Use setTimeout for demo
            setTimeout(() => {
                this.$refs.topProgress.done()
            }, 2000)
        },

        components: {
            vueTopprogress
        }
    }
</script>
