# MyLibrary PHP Library

A modular PHP library designed for WordPress projects, providing structured models, services, controllers, and utilities to handle posts, taxonomies, AJAX, and more.

---

## Table of Contents

- [Overview](#overview)  
- [Architecture](#architecture)  
- [Components](#components)  

---

## Overview

This library offers a set of PHP classes and traits that help organize WordPress development with:

- Post and taxonomy models  
- Services for business logic (e.g., breadcrumb generation, post queries)  
- Controllers including AJAX handlers  
- Tree structures for terms and posts  
- Helper traits for common functionality  

---

## Architecture

The library follows a modular, object-oriented design pattern:

- **Models:** Encapsulate data and related logic (e.g., `Post`, `TermsPostsTreeNode`)  
- **Traits:** Reusable method sets for common functionality (e.g., `CommonPostMethods`)  
- **Services:** Business logic (e.g., `BreadcrumbService`, `BlogPostService`)  
- **Controllers:** Handle HTTP requests and AJAX (e.g., `CommonPostController`, `BlogPostAjaxController`)  
- **Managers:** Register hooks and orchestrate interactions (e.g., `AjaxManager`)  

---

## Components

### Models

- `Post` — Base abstract class for posts using WordPress posts internally  
- `TermsPostsTreeNode` — Tree node class to build hierarchical term/post structures  

### Traits

- `CommonPostMethods` — Common post data getters and setters  
- `CommonPostTaxonomyMethods` — (Not shown but typically used for taxonomy-related functionality)  

### Services

- `BreadcrumbService` — Generate breadcrumb navigation arrays from terms and custom items  
- `BlogPostService` — Implements post retrieval and business logic for blog posts  

### Controllers

- `CommonPostController` — Base post controller handling query and request data  
- `BlogPostAjaxController` — AJAX controller for filtering blog posts with pagination  

### Managers

- `AjaxManager` — Registers AJAX actions and routes requests to appropriate controllers  

---
