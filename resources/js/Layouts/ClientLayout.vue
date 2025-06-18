<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3'

import { ExtendedPageProps } from '@/Components/Admin/Form/AsideField.vue'
import FooterNavigation from '@/Components/FooterNavigation.vue'
import MainNavigation from '@/Components/MainNavigation.vue'
import { Menu } from '@/types/models/menu'
import { getBlockCpt } from '@/utils/mapping'
import { getMenu } from '@/utils/utils'

import type { Page } from '@/types/models/page'

defineProps<{
  page: Page
  menus: Menu[]
}>()

const pageProps = usePage<ExtendedPageProps>().props
const menu = getMenu('main-navigation')
const footer = getMenu('footer-navigation')
</script>

<template>
  <Head :title="page.meta_title">
    <meta name="description" :content="page.meta_description" />
    <meta property="og:title" :content="page.meta_title" />
    <meta property="og:description" :content="page.meta_description" />
    <meta property="og:type" :content="page.og_type" />
    <meta property="og:url" :content="pageProps.ziggy.location" />
  </Head>

  <h1 class="sr-only">{{ page.title }}</h1>
  <div class="bg-black font-space font-normal text-white">
    <MainNavigation v-if="menu" :menu="menu" />
    <main class="flex flex-col">
      <Suspense>
        <component
          v-for="block in page.blocks"
          :key="block.id"
          :is="getBlockCpt(block.block_type.type)"
          :content="block.content"
        />
      </Suspense>
    </main>
    <FooterNavigation v-if="footer" :menu="footer" />
  </div>
</template>

<style scoped></style>
