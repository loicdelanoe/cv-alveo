import { Component } from 'vue'

import FileInput from '@/Components/Admin/Form/FileInput.vue'
import GalleryInput from '@/Components/Admin/Form/GalleryInput.vue'
import ImageInput from '@/Components/Admin/Form/ImageInput.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import MarkdownInput from '@/Components/Admin/Form/MarkdownInput.vue'
import RepeaterInput from '@/Components/Admin/Form/RepeaterInput.vue'
import TextAreaInput from '@/Components/Admin/Form/TextAreaInput.vue'
import VideoInput from '@/Components/Admin/Form/VideoInput.vue'
import IconBlock from '@/Components/Admin/Icon/IconBlock.vue'
import IconCheck from '@/Components/Admin/Icon/IconCheck.vue'
import IconCollection from '@/Components/Admin/Icon/IconCollection.vue'
import IconMedia from '@/Components/Admin/Icon/IconMedia.vue'
import IconMenu from '@/Components/Admin/Icon/IconMenu.vue'
import IconPage from '@/Components/Admin/Icon/IconPage.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import IconSquareArrowRight from '@/Components/Admin/Icon/IconSquareArrowRight.vue'
import AboutBlock from '@/Components/Blocks/AboutBlock.vue'
import ContactBlock from '@/Components/Blocks/ContactBlock.vue'
import HeroBlock from '@/Components/Blocks/HeroBlock.vue'
import OpinionBlock from '@/Components/Blocks/OpinionBlock.vue'
import SkillBlock from '@/Components/Blocks/SkillBlock.vue'

export const getInputCpt = (fieldType: string) => {
  const cptMap: { [key: string]: Component } = {
    textarea: TextAreaInput,
    file: FileInput,
    image: ImageInput,
    repeater: RepeaterInput,
    markdown: MarkdownInput,
    gallery: GalleryInput,
    video: VideoInput,
  }

  return cptMap[fieldType] || InputLabel
}

export const getBlockCpt = (blockType: string) => {
  const cptMap: { [key: string]: Component } = {
    hero: HeroBlock,
    contact: ContactBlock,
    about: AboutBlock,
    opinion: OpinionBlock,
    skills: SkillBlock,
  }

  return cptMap[blockType]
}

export const getIconCpt = (icon: string) => {
  const cptMap: { [key: string]: Component } = {
    plus: IconPlus,
    check: IconCheck,
    'square-arrow': IconSquareArrowRight,
    page: IconPage,
    collection: IconCollection,
    block: IconBlock,
    media: IconMedia,
    menu: IconMenu,
  }

  return cptMap[icon] || IconPlus
}
