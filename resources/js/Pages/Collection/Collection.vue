<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3'
import { Component } from 'vue'

import { ExtendedPageProps } from '@/Components/Admin/Form/AsideField.vue'
import { Menu } from '@/types/models/menu'
import { getMenu } from '@/utils/utils'

defineProps<{
  // TODO: Type this
  collectionPage: any
  menus: Menu[]
}>()

const getCollectionPage = (type: string) => {
  const cptMap: { [key: string]: Component } = {}

  return cptMap[type]
}

const pageProps = usePage<ExtendedPageProps>().props

const menu = getMenu('main-navigation')
const footer = getMenu('footer-navigation')
</script>

<template>
  <Head :title="collectionPage.meta_title">
    <meta name="description" :content="collectionPage.meta_description" />
    <meta property="og:title" :content="collectionPage.meta_title" />
    <meta property="og:description" :content="collectionPage.meta_description" />
    <meta property="og:type" :content="collectionPage.og_type" />
    <meta property="og:url" :content="pageProps.ziggy.location" />
  </Head>
  <!-- <MainNavigation v-if="menu" :menu="menu" /> -->
  <h1 class="sr-only">{{ collectionPage.title }}</h1>
  <main>
    <component
      :is="getCollectionPage(collectionPage.collection_type.type)"
      :collection="collectionPage"
    />
  </main>
  <!-- <Footer v-if="footer" :menu="footer" /> -->
</template>

<style scoped></style>
