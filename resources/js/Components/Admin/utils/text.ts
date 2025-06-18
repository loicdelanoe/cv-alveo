import DOMPurify from 'isomorphic-dompurify'
import { marked } from 'marked'

export const slugify = (text: string, prefix?: string) => {
  if (prefix) {
    return prefix + text
    .toLowerCase() // Convert to lowercase
    .normalize('NFD') // Normalize accents
    .replace(/[\u0300-\u036f]/g, '') // Remove diacritics
    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
    .trim() // Remove whitespace from start and end
    .replace(/\s+/g, '-') // Replace spaces with hyphens
    .replace(/-+/g, '-') // Remove multiple hyphensend of text
  }

  return text
    .toLowerCase() // Convert to lowercase
    .normalize('NFD') // Normalize accents
    .replace(/[\u0300-\u036f]/g, '') // Remove diacritics
    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
    .trim() // Remove whitespace from start and end
    .replace(/\s+/g, '-') // Replace spaces with hyphens
    .replace(/-+/g, '-') // Remove multiple hyphensend of text
}

export const renderMarkdown = (text: string) => {
  return DOMPurify.sanitize(marked.parse(text) as string)
}
