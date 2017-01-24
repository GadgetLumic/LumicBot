from asyncio import coroutine

from .plugins import LumicbotPlugin



help_plugin = LumicbotPlugin("Help Command", author="Freddy Roykyr Sturmovik", description="A /help command that lists commands and features, as defined by plugins")



@help_plugin.trigger

@coroutine

def trigger(text):

    return text.lower().startswith("/help")



@help_plugin.helplines

@coroutine

def help():

    return ['"/help" - Show this help']



@help_plugin.group_chat

@coroutine

def reaction(text, sender, respond):

    response = "Gadget-Gadget! I am Gadget Lumic,this automatic A.I will always attempt within its limits to satisfy your expectations.\n\nThese are my parameters of competence:\n\n"

    from . import plugins

    lines = []

    for plugin in plugins:

        if plugin.helptext_func:

            lines.extend((yield from plugin.helptext_func()))

    yield from respond(response + '\n'.join(' *  '+line for line in sorted(lines, key=lambda line: line.replace("\"", ""))))
