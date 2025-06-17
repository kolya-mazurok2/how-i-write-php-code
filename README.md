# MyLibrary PHP Library

A modular PHP library designed for WordPress projects, providing structured models, services, controllers, and utilities to handle posts, taxonomies, AJAX, and more.

---

## Table of Contents

- [Overview](#overview)  
- [Architecture](#architecture)  
- [Components](#components)
- [AssetsLoader Bundle](#assetsloader-bundle)

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

## AssetsLoader Bundle

The **AssetsLoader** bundle is a modular and extensible system designed for managing asset loading (CSS/JS) in WordPress with a clear separation of concerns and configurability.

### Key Design Patterns Used

- **Strategy Pattern:**  
  Different resource configurations (`Primary`, `Secondary`, `Tertiary`, etc.) implement a common interface (`ResourceConfig`), allowing dynamic selection and usage of these strategies depending on the current page type.

- **Factory / Class Map Pattern:**  
  Uses class maps (such as `PageTypeResource::MAP` and other mapping arrays) to instantiate resource configuration classes based on page types, enabling easy extensibility and decoupling between page logic and resource loading.

- **Dependency Injection:**  
  The `ResourceRenderService` receives dependencies like the resource list and the current post via constructor and setter methods, promoting loose coupling and easier testing.

- **Template Method Pattern:**  
  The abstract class `CommonResourceConfig` defines a generic template method (`get()`) that merges global and local resource configurations, while subclasses implement the specific resource details in `getLocal()`.

- **Interface Segregation and Polymorphism:**  
  Interfaces such as `ResourceConfig` and `PageTypeCondition` enforce contracts for resource configuration and page type checks, enabling polymorphic handling of different resource sets and page conditions.

- **Single Responsibility Principle:**  
  Separation of concerns is maintained by isolating page type detection (`PageTypeCondition` implementations), resource configuration (`ResourceConfig` implementations), and resource rendering (`ResourceRenderService`).

---

This architecture allows easy extension for new page types or resources, flexible asset management, and clear, maintainable code.
