from asyncio import coroutine

from .plugins import LumicbotPlugin

from random import random, choice



randomchirp = LumicbotPlugin("Random Beeping", author="Freddy Roykyr Sturmovik", description="Lets the bot randomly beep.")



@randombeep.trigger

@coroutine

def trigger(text):

    return random() <= 0.02 # chance: about once every 50 lines



@randombeep.group_chat

@coroutine

def reaction(text, sender, respond):

    yield from respond(choice(["BeepBeepBup"]))
