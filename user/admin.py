from django.contrib import admin
from .models import Post, Profile, Tag, Category, Comment

class PostAdmin(admin.ModelAdmin):
    list_display = ('title', 'created_on', 'updated_on')
    list_filter = ('tags', 'created_on', 'updated_on')
    search_fields = ('title',)
    prepopulated_fields = {'slug': ('title',)} # this create the slug field from the title field
    autocomplete_fields = ('tags',)

admin.site.register(Post, PostAdmin)
admin.site.register(Profile)

# TagAdmin must define "search_fields", because it's referenced by PostAdmin.autocomplete_fields.
class CategoryAdmin(admin.ModelAdmin):
    search_fields = ('name',)

# Register your models here.
admin.site.register(Category, CategoryAdmin)

# TagAdmin must define "search_fields", because it's referenced by PostAdmin.autocomplete_fields.
class TagAdmin(admin.ModelAdmin):
    search_fields = ('name',)

# Register your models here.
admin.site.register(Tag, TagAdmin)
admin.site.register(Comment)